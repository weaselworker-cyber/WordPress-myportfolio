<?php
function my_portfolio_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus(array(
        'primary' => 'メインメニュー',
    ));
}

add_action('after_setup_theme', 'my_portfolio_theme_setup');

function my_portfolio_enqueue_styles()
{
    wp_enqueue_style(
        'my-portfolio-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );
    wp_enqueue_script(
        'my-portfolio-script',
        get_template_directory_uri() . '/script.js',
        array(),
        '1.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'my_portfolio_enqueue_styles');

// カスタム投稿タイプ
function my_portfolio_register_works()
{

    register_post_type('works', array(
        'labels' => array(
            'name' => '制作実績',
            'singular_name' => '制作実績',
            'add_new' => '新規追加',
            'add_new_item' => '制作実績を追加',
            'edit_item' => '制作実績を編集',
        ),

        'public' => true,
        'has_archive' => true,

        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',

        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),
    ));

}
add_action('init', 'my_portfolio_register_works');

//制作実績にURL入力欄を追加
function my_portfolio_add_works_url_field(){
    add_meta_box(
        'works_url',
        '制作URL',
        'my_portfolio_works_url_callback',
        'works',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'my_portfolio_add_works_url_field');

//URL入力欄の表示
function my_portfolio_works_url_callback($post){
    $works_url = get_post_meta($post->ID, '_works_url', true);
    ?>
    <?php wp_nonce_field('my_portfolio_save_works_url', 'my_portfolio_works_url_nonce'); ?>

    <label for="works_url">制作したサイトのURL：</label>
    <input type="url" id="works_url" name="works_url" value="<?php echo esc_url($works_url); ?>" style="width: 100%;" placeholder="https://example.com">
    <?php
}

// 制作URLを安全に保存する
function my_portfolio_save_works_url($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (get_post_type($post_id) !== 'works') {
        return;
    }
    if (!isset($_POST['my_portfolio_works_url_nonce'])) {
        return;
    }
    if (!wp_verify_nonce(
        sanitize_text_field(wp_unslash($_POST['my_portfolio_works_url_nonce'])),
        'my_portfolio_save_works_url'
    )) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (!isset($_POST['works_url'])) {
        return;
    }

    $works_url = esc_url_raw(wp_unslash($_POST['works_url']));
    update_post_meta($post_id, '_works_url', $works_url);
}
add_action('save_post', 'my_portfolio_save_works_url');