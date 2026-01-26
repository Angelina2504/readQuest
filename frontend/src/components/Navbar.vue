<template>
  <nav class="navbar">
    <div class="navbar-logo">
      <router-link to="/" class="logo">
        <img src="@/assets/logo/logoLessBG.png" alt="Logo ReadQuest" />
      </router-link>
    </div>
    <div class="navbar-menu">
      <router-link to="/" class="button-home">
        <img src="@/assets/icons/bookclose.png" alt="icons book"></img>
        <p>Accueil</p>
      </router-link>
      <router-link to="/" class="button-aboutUs ">
        <img src="@/assets/icons/bookclose.png" alt="icon book">
        <p>Notre histoire</p>
      </router-link>
      <router-link to="/" class="button-profil">
        <img src="@/assets/icons/bookclose.png" alt="icon book"></img>
        <p>Profil</p>
      </router-link>
      <router-link to="/" class="button-quests">
        <img src="@/assets/icons/bookclose.png" alt="icon book"></img>
        <p>Quêtes</p>
      </router-link>
    </div>
  </nav >
</template>

<script>
import router from '@/router';
export default {name: 'Navbar'}

</script>

<style scoped>
.navbar{
  display:flex;
  flex-direction: column;
  align-items: center;
  background: #F9F5F0;
}

.navbar-menu{
display: flex;
gap: 5rem;
border: 2px solid #944242;
padding: 3rem;

}

</style>
