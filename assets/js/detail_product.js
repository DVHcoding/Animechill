/**
* COMMENT
*/

const commentInput = document.querySelector("[data-comment-input]");
const commentIcon = document.querySelector("[data-comment-icon]");

// Lắng nghe sự kiện khi người dùng nhập vào ô input
commentInput.addEventListener('input', function () {
    if (commentInput.value.trim() !== '') {
        // Nếu có văn bản trong ô input, đổi màu nút
        commentIcon.classList.add('active');
    } else {
        // Nếu ô input trống, trở về màu mặc định
        commentIcon.classList.remove('active');
    }
});


/**
* CHAPTER LIST
*/

const chapterBtn = document.getElementById('chapter-btn');
const chapterList = document.getElementById('chapter-list');
const chapterIcon = document.getElementById('chapter-icon');


chapterBtn.addEventListener('click', function () {
    chapterList.classList.toggle('active');
    if (chapterList.classList.contains('active')) {
        chapterIcon.style.transform = 'rotate(180deg)'
    } else {
        chapterIcon.style.transform = 'rotate(0deg)'
    }
});


