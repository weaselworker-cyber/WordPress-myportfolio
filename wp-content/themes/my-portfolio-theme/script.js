const openButtons = document.querySelectorAll(".work-open-button");

//モーダルを開く
openButtons.forEach((button)=>{
    button.addEventListener("click",() =>{
        const modalId = button.dataset.modalId;
        const modal = document.getElementById(modalId);
        modal.hidden = false;
    });
});

//モーダルを閉じる
const closeButtons = document.querySelectorAll(".work-modal-close");
closeButtons.forEach((button) => {
    button.addEventListener("click",() => {
        const modal = button.closest(".work-modal");
        modal.hidden = true;
    });
});

//モーダルの背景をクリックしたときの処理
const modals = document.querySelectorAll(".work-modal");
modals.forEach((modal) => {
    modal.addEventListener("click",(event) => {
        if (event.target === modal) {
            modal.hidden = true;
        }
    });
});

//トップへ戻るボタン
const scrollTopButton = document.getElementById("scroll-top-button");
window.addEventListener("scroll", () => {
    if(window.scrollY > 200){
        scrollTopButton.style.display = "block";
    } else {
        scrollTopButton.style.display = "none";
    }
});

scrollTopButton.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});