import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

window.togglePassword = function(inputToggle){
    let input = inputToggle.parentElement.querySelector('input');
    inputToggle.classList.toggle('fa-eye-slash');
    inputToggle.classList.toggle('fa-eye');
    input.type = input.type === 'password' ? 'text' : 'password';
}

window.addEventListener('DOMContentLoaded', (event) => {
    document.querySelector('#menu-button').addEventListener('click', function(){
        let menu = document.querySelector('#menu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('block');
    });
    //click away from menu to close
    document.addEventListener('click', function(event) {
        let menu = document.querySelector('#menu');
        let menuButton = document.querySelector('#menu-button');
        if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
            menu.classList.add('hidden');
            menu.classList.remove('block');
        }
    });
});
