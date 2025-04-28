const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});


// Contrôle de l'affichage du profil avec `user-btn`
let profile = document.querySelector('.header .flex .profile');
let userBtn = document.querySelector('#user-btn');
if (userBtn) {
    userBtn.onclick = () => {
        profile.classList.toggle('active');
        let search = document.querySelector('.header .flex .search-form');
        if (search) search.classList.remove('active'); // Ferme la barre de recherche si elle est ouverte
    };
}
