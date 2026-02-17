<template>
    <footer>

    </footer>
</template>
<script setup>

const menuItems = reactive([
  { text: 'Notre histoire', path: '/about', isHovered: false },
  { text: 'Quêtes', path: '/quests', isHovered: false },
  { text: 'Profil', path: '/profil', isHovered: false, isUser: true },
  { text: 'Inscription', path: '/signin', isHovered: false, isUser: true },
  { text: 'Se conecter', path: '/lingin', isHovered: false, isUser: true },
  { text: 'Politique de confidentialité', path:'/politique', isHovered: false},
  { text: 'RGPD', path: '/rgpd', isHovered: false},
  { text: 'Livresse_Podcast', url :'https://linktr.ee/LivressePodcast', isHovered:false}
]);

  </script>
<style scoped></style>