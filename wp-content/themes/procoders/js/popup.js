const popupBtns = document.querySelectorAll('.popup-btn a');
const popUpBox = document.getElementById('nav-pop');

if (popupBtns.length > 0) {
    popupBtns.forEach(popupBtn => {
        popupBtn.addEventListener('click', function() {
            if (popUpBox.style.display === 'none') {
                popUpBox.style.display = 'block';
            } else {
                popUpBox.style.display = 'none';
            }
        });

        document.addEventListener('click', function(event) {
            if (!popUpBox.contains(event.target) && !popupBtn.contains(event.target)) {
                popUpBox.style.display = 'none';
            }
        });
    });
}
