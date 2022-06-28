// on indexe les classes
const mainMenu = document.querySelector('.mainMenu');
const closeMenu = document.querySelector('.closeMenu');
const openMenu = document.querySelector('.openMenu');
// on associe l'évènement "click" aux fonctions show() et close()
openMenu.addEventListener('click', show);
closeMenu.addEventListener('click', close);
//création de la fonction show()
function show() {
    mainMenu.style.display = 'flex';
    mainMenu.style.top = '0';
}
//création de la fonction close()
function close() {
    mainMenu.style.top = '-100%';
}