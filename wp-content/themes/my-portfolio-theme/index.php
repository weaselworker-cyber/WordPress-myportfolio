<?php get_header(); ?>

<main>
    <section class="hero">
        <p class="hero-label">MY PORTFOLIO</p>
        <h1>Web Developer in Training</h1>
        <p class="hero-description">Web制作を学びながら使いやすいWebサイトを目指しています。</p>
        <a class="hero-button" href="#about">About me</a>
    </section>

    <section class="about" id="about">
        <h2>About Me</h2>
        <p class="about-lead">使いやすいWebサイトを作ることを目指しています。</p>

        <div class="about-card">
            <h3>Profile</h3>
            <p>Web制作を学習中です。</p>
            <p>HTMLとCSSを使って、Webサイトの作り方を学んでいます。</p>
        </div>
    </section>

    <section class="skills" id="skills">
        <h2>My Skills</h2>
        <p class="skills-description">現在学習している技術の紹介</p>

        <div class="skills-container">
            <div class="skill-card">
                <h3>HTML</h3>
                <p>Webページの構造を作ります。</p>
                <div class="skill-progress">
                    <div class="skill-progress-fill" style="--skill-width: 80%; width: 80%;"></div>
                </div>
                <span class="skill-level">80%</span>
            </div>

            <div class="skill-card">
                <h3>CSS</h3>
                <p>Webページの見た目を整えます。</p>
                <div class="skill-progress">
                    <div class="skill-progress-fill" style="--skill-width: 70%; width: 70%;"></div>
                </div>
                <span class="skill-level">70%</span>
            </div>

            <div class="skill-card">
                <h3>JavaScript</h3>
                <p>Webページに動きを加えます。</p>

                <div class="skill-progress">
                    <div class="skill-progress-fill" style="--skill-width: 55%; width: 55%;"></div>
                </div>
                <span class="skill-level">55%</span>
            </div>
        </div>
    </section>

    <section class="works" id="works">
        <h2>My Works</h2>
        <p>これまでに制作した作品の紹介</p>
        <div class="works-container">
            <?php
            $works_query = new WP_Query(array(
                'post_type' => 'works',
                'posts_per_page' => 6,
            ));

            if ($works_query->have_posts()):
                while ($works_query->have_posts()):
                    $works_query->the_post();
                    ?>

                    <div class="work-card">
                        <h3><?php echo esc_html(get_the_title()); ?></h3>

                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php endif; ?>

                        <button type="button" class="work-open-button" data-modal-id="work-modal-<?php echo esc_attr('work-modal-' . get_the_ID()); ?>">
                            詳細を見る
                        </button>
                        <div class="work-modal" id="work-modal-<?php echo esc_attr('work-modal-' . get_the_ID()); ?>" hidden>
                            <div class="work-modal-content">                                
                                <button type="button" class="work-modal-close">
                                    ×
                                </button>
                                <h3><?php echo esc_html(get_the_title()); ?></h3>
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php endif; ?>
                                <div class="work-modal-description">
                                    <?php echo wp_kses_post(get_the_content()); ?>
                                </div>
                                <?php $works_url = get_post_meta(get_the_ID(), '_works_url', true); ?>
                                <?php if (!empty($works_url)) : ?>
                                <p class="work-modal-link">
                                    <a href="<?php echo esc_url($works_url); ?>" target="_blank" rel="noopener noreferrer">
                                        制作サイトを見る
                                    </a>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                ?>

                <p>制作実績はまだありません。</p>

            <?php endif; ?>
        </div>
    </section>

    <section class="contact" id="contact">
        <h2>Contact</h2>
        <p class="contact-description">お問い合わせ</p>

        <div class="contact-form">
            <?php echo do_shortcode('[contact-form-7 id="0b3b506" title="お問い合わせフォーム"]');?>
        </div>
    </section>
</main>

<?php get_footer(); ?>