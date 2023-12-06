import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', function () {

    var alert = document.getElementById('postAlert');

    if (alert) {
        var btnClose = document.getElementById('postAlertClose');
        btnClose.addEventListener('click', function () {
            alert.style.display = 'none';
        })
    }
});

document.addEventListener('DOMContentLoaded', function () {

    var toggleButtons = document.querySelectorAll('.toggle-comments-btn');

    if (toggleButtons.length == 1) {
        let postId = toggleButtons[0].getAttribute('data-post-id');
        var commentsSection = document.querySelector('[data-comments-id="' + postId + '"]');
        commentsSection.classList.toggle('hidden');
    }

    toggleButtons.forEach(function (button) {
        button.addEventListener('click', () => {
            let postId = button.getAttribute('data-post-id');
            var commentsSection = document.querySelector('[data-comments-id="' + postId + '"]');
            commentsSection.classList.toggle('hidden');
        });
    });
});
