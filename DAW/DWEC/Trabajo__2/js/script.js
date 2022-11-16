let btn = document.getElementById('onOff');

btn.addEventListener('click', function () {
    let video = document.getElementById('gameVideo');
    video.style.display = 'block';
    video.play();
    btn.addEventListener('click', function () {
        video.style.display = 'none';
        video.pause();
    });
});