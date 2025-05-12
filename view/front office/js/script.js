let body = document.body;
let darkMode = localStorage.getItem('dark-mode');




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
