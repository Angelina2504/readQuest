<template>
  <footer class="footer">
    <div class="footer-column">
      <h3>Lien du site :</h3>
      <nav class="footer-nav">
        <template v-for="link in menuLinks" :key="link.text">
          <router-link v-if="link.path" :to="link.path" class="footer-link">
            {{ link.text }}
          </router-link>
          <a v-else :href="link.url" target="_blank" rel="noopener" class="footer-link">
            {{ link.text }}
          </a>
        </template>
      </nav>
    </div>

    <div class="footer-column center">
      <h3>Réseaux Sociaux</h3>
      <div class="social-icons">
        <a v-for="social in imgLinks" :key="social.name" :href="social.url" target="_blank">
          <img :src="`/src/assets/icons/${social.icons}`" :alt="social.name" />
        </a>
      </div>
    </div>

    <div class="footer-logo">
      <router-link to="/">
        <img src="@/assets/logo/logoImgLessBG.png" alt="Logo ReadQuest" />
      </router-link>
    </div>

    <div class="footer-column right">
      <h3>Crédibilité et sécurité</h3>
      <p>© 2025 ReadQuest</p>
      <a v-for="security in securityLinks" :key="security.text" :to="security.path" class="footer-link">{{security.text}}</a>
    </div>

    <div class="footer-columnright2">
      <h3>Partenaire</h3>
      <a v-for="partner in partnerLinks" :key="partner.text" :href="partner.url" target="_blank" class="footer-link">{{partner.text}}</a>
    </div>
  </footer>
</template>

<script setup>

const menuLinks = ([
  { text: 'Notre histoire', path: '/about', isHovered: false },
  { text: 'Quêtes', path: '/quests', isHovered: false },
  { text: 'Profil', path: '/profil', isHovered: false, isUser: true },
  { text: 'Inscription', path: '/signin', isHovered: false, isUser: true },
  { text: 'Se connecter', path: '/login', isHovered: false, isUser: true },
 
]);

const securityLinks =([
  {text: 'Politique de confidentialité', path:'/politique', isHovered: false},
  { text: 'RGPD', path: '/rgpd', isHovered: false},
])

const imgLinks = ([
  {name: 'Instagram', url : 'https://www.instagram.com/', icons: 'insta.png',isHovered: false},
  {name: 'Facebook', url : 'https://www.facebook.com/', icons: 'facebook.png',isHovered: false}
]);

const partnerLinks = ([ 
  { text: 'Livresse_Podcast', url :'https://linktr.ee/LivressePodcast', isHovered:false}
])

  </script>

<style scoped>
.footer {
  display: flex;
  justify-content: space-around;
  align-items: flex-start;
  background: #F9F5F0;
  padding: 40px 20px;
}

.footer-column {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 150px;
}

.footer-column h3 {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 10px;
  color: #333;
}

.footer-nav {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 5px 20px; 
}

.footer-link {
  text-decoration: none;
  color: #333;
  font-size: 14px;
  transition: color 0.3s ease;
}

.footer-link:hover {
  color: #944242;
}

.center {
  align-items: center;
}

.social-icons {
  display: flex;
  gap: 15px;
}

.social-icons img {
  width: 35px;
  height: 35px;
  transition: transform 0.2s;
}

.social-icons img:hover {
  transform: scale(1.1);
}

.footer-logo img {
  height: 100px;
  width: auto;
}

.right {
  text-align: right;
  align-items: flex-end;
}

.right p {
  margin: 0;
  font-size: 13px;
}
</style>