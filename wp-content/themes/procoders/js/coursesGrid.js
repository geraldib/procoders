const homeUrl = document.getElementById('home-url').dataset.homeurl;
const loadBtn = document.getElementById('course-load');
const courseGrid = document.getElementById('course-grid');
const filterStates = document.querySelectorAll('.course-grid__state');
let pageNr = 2;
let stateSlug = 'state-1'

loadBtn.addEventListener('click', function() {
    fetch(homeUrl + '/wp-json/custom/v1/courses?page=' + pageNr + '&slug=' + stateSlug)
    .then((response) => response.json())
    .then((response) => {
        pageNr++;
        courseGrid.innerHTML += response.html;  
        if (response.next) {
            if (loadBtn.classList.contains('course-grid__load--disabled')) {
                loadBtn.classList.remove('course-grid__load--disabled');
            }
        } else {
            if (!loadBtn.classList.contains('course-grid__load--disabled')) {
                loadBtn.classList.add('course-grid__load--disabled');
            }
        }    
    });
});

filterStates.forEach(state => {
    pageNr = 2;
    state.addEventListener('click', function(event) {
        stateSlug = event.target.dataset.slug;

        let sibling = state.previousElementSibling || state.nextElementSibling;
        if (sibling) {
          sibling.classList.remove('course-grid__state--active');
        }
        state.classList.add('course-grid__state--active');

        fetch(homeUrl + '/wp-json/custom/v1/courses?page=' + pageNr + '&slug=' + stateSlug + '&filter=yes')
        .then((response) => response.json())
        .then((response) => {
            courseGrid.innerHTML = response.html;  
            if (response.next) {
                if (loadBtn.classList.contains('course-grid__load--disabled')) {
                    loadBtn.classList.remove('course-grid__load--disabled');
                }
            } else {
                if (!loadBtn.classList.contains('course-grid__load--disabled')) {
                    loadBtn.classList.add('course-grid__load--disabled');
                }
            }    
        });
    });
});
