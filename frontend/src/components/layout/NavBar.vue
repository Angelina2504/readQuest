<template>
  <nav class="navbar">
    <div class="navbar-logo">
      <router-link to="/">
        <img src="@/assets/logo/logoLessBG.png" alt="Logo ReadQuest" />
      </router-link>
    </div>

    <button class="burger" :class="{ open: menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>

  <div class="navbar-menu" :class="{ 'menu-open': menuOpen }">
    <template
        v-for="item in menuItems"
        :key="item.text">
      <router-link
        v-if="(!item.guestOnly || !authStore.isAuthenticated) && (!item.requiresAuth || authStore.isAuthenticated)"
        :to="item.path"
        class="nav-item"
        @mouseenter="item.isHovered = true"
        @mouseleave="item.isHovered = false"
        @click="menuOpen = false"
      >
        <img 
          :src="item.isHovered ? item.iconOpen : item.iconClosed" 
          :alt="item.text" 
        />
        <p>{{ item.text }}</p>
      </router-link>
    </template>
  <div
  class="nav-item"
  v-if="authStore.isAuthenticated"
    @click="handleLogout(); menuOpen = false"
    @mouseenter="authHover = true"
    @mouseleave="authHover = false">
  <img 
    :src="authHover ? icons.open : icons.closed" 
    alt="Auth icon" >
    <p>Se déconnecter</p>
</div>
<router-link v-else
  to="/login"
  class="nav-item"
  @mouseenter="authHover = true"
  @mouseleave="authHover = false"
  @click="menuOpen = false">
  <img
    :src="authHover ? icons.open : icons.closed"
    alt="Auth icon"
  />
  <p>Se connecter</p>
</router-link>
</div>

  </nav>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useRouter } from 'vue-router';

const authStore = useAuthStore()
const router = useRouter()

const icons = {
  closed: new URL('@/assets/icons/bookClose.png', import.meta.url).href,
  open: new URL('@/assets/icons/bookOpen.png', import.meta.url).href
};

const authHover = ref(false);
const menuOpen = ref(false);

const menuItems = reactive([
  { text: 'Accueil', path: '/', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false },
  { text: 'Notre histoire', path: '/about', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false },
  { text: 'Quêtes', path: '/quests', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false },
  { text: 'Ma Bibliothèque', path: '/bibliotheque', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false, requiresAuth: true},
  { text: 'Profil', path: '/profil', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false},
  { text: 'Inscription', path: '/signin', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false, guestOnly:true },
  { text: 'Contactez-nous', path: '/contact', iconClosed: icons.closed, iconOpen: icons.open, isHovered: false},
]);

function handleLogout() {
  authStore.logout()
  router.push('/login')
}

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
  border: 2px solid #833c3c;
  border-radius: 50px;
  padding: 4px 32px;
  background: #FFFFFF; /* Fond blanc comme sur ton image */
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.nav-item {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  color: #333333;
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
  color: #833c3c;
}

/* ── Sticky ── */
.navbar {
  position: sticky;
  top: 0;
  z-index: 100;
}

/* ── Burger (caché sur desktop) ── */
.burger {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 5px;
  width: 36px;
  height: 36px;
  background: none;
  border: none;
  cursor: pointer;
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%);
}
.burger span {
  display: block;
  width: 24px;
  height: 2px;
  background: #833c3c;
  border-radius: 2px;
  transition: transform 0.3s, opacity 0.3s;
}
.burger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.burger.open span:nth-child(2) { opacity: 0; }
.burger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ── Tablette : pill plus compact (992px → 768px) ── */
@media (min-width: 768px) and (max-width: 992px) {
  .navbar-menu {
    gap: 0;
    padding: 4px 12px;
  }
  .nav-item {
    padding: 8px 8px;
  }
  .nav-item p {
    font-size: 12px;
  }
  .nav-item img {
    width: 18px;
  }
}

/* ── Mobile : burger + drawer (< 768px) ── */
@media (max-width: 768px) {
  .navbar {
    position: sticky;
    padding: 12px 0 10px;
  }
  .navbar-logo img {
    height: 56px;
    margin-bottom: 0;
  }
  .burger {
    display: flex;
  }
  .navbar-menu {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #FFFFFF;
    border-top: 2px solid #833c3c;
    border-radius: 0 0 16px 16px;
    padding: 8px 20px 16px;
    gap: 0;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    z-index: 200;
  }
  .navbar-menu.menu-open {
    display: flex;
  }
  .nav-item {
    padding: 13px 8px;
    border-bottom: 1px solid #EDE4D3;
    width: 100%;
    font-size: 15px;
  }
  .nav-item:last-child {
    border-bottom: none;
  }
  .nav-item img {
    width: 22px;
  }
  .nav-item p {
    font-size: 15px;
  }
}
</style>