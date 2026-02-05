<template>
  <nav class="navbar">
    <div class="navbar-logo">
      <router-link to="/">
        <img src="@/assets/logo/logoLessBG.png" alt="Logo ReadQuest" />
      </router-link>
    </div>

    <div class="navbar-menu">
      <router-link 
        v-for="item in menuItems" 
        :key="item.text"
        :to="item.path"
        class="nav-item"
        @mouseenter="item.isHovered = true"
        @mouseleave="item.isHovered = false"
      >
        <img 
          :src="item.isHovered ? item.iconOpen : item.iconClosed" 
          :alt="item.text" 
        />
        <p>{{ item.text }}</p>
        <span v-if="item.isUser && user" class="user-name">{{ user.name }}</span>
      </router-link>

      <router-link 
        :to="isAuthenticated ? '/profil' : '/login'" 
        class="nav-item"
        @mouseenter="authHover = true"
        @mouseleave="authHover = false"
      >
        <img 
          :src="authHover ? icons.open : icons.closed" 
          alt="Auth icon" 
        />
        <p>{{ isAuthenticated ? 'Se déconnecter' : 'Se connecter' }}</p>
      </router-link>
    </div>
  </nav>
</template>

<script setup>
import { ref, reactive } from 'vue';

const props = defineProps({
  isAuthenticated: { type: Boolean, default: false },
  user: { type: Object, default: null },
});

const icons = {
  closed: new URL('@/assets/icons/bookclose.png', import.meta.url).href,
  open: new URL('@/assets/icons/bookopen.png', import.meta.url).href
};

const authHover = ref(false);
 
const menuItems = reactive([
  { text: 'Accueil', path: '/', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false },
  { text: 'Notre histoire', path: '/about', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false },
  { text: 'Quêtes', path: '/quests', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false },
  { text: 'Profil', path: '/profil', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false, isUser: true },
  { text: 'Inscription', path: '/signin', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false, isUser: true },
]);
</script>

<style scoped>
.navbar {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #F9F5F0;
  padding: 20px 0;
}

.navbar-logo img {
  height: 90px; 
  width: auto;
  margin-bottom: 8px;
}

.navbar-menu {
  display: flex;
  gap: 24px;
  border: 2px solid #944242;
  border-radius: 50px;
  padding: 4px 32px;
  background: white; /* Fond blanc comme sur ton image */
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.nav-item {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  color: #333;
  padding: 8px 12px;
  transition: all 0.3s ease;
}

.nav-item img {
  width: 24px;
  height: auto;
}

.nav-item p {
  margin: 0;
  font-weight: 500;
  font-size: 14px;
}

.nav-item:hover p {
  color: #944242;
}
</style>