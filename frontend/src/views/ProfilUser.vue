<template>
  <div class="profil-container">

    <div class="content">
      <ProfilInfos v-if="activeTab === 'infos'" />
      <ProfilCarte v-if="activeTab === 'carte'" />
    </div>

    <div class="tabs">
      <button class="Compte" :class="{ active: activeTab === 'infos' }" @click="activeTab = 'infos'">Mon compte</button>
      <button class="Lecteur" :class="{ active: activeTab === 'carte' }" @click="activeTab = 'carte'">Carte lecteur</button>
    </div>

  </div>
</template>

<script setup>
import ProfilCarte from '@/components/profil/ProfilCarte.vue';
import ProfilInfos from '@/components/profil/ProfilInfos.vue';
import { ref } from 'vue';

const activeTab = ref('infos')

</script>

<style scoped>
.profil-container {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: center;
  padding: 40px 20px;
  background-color: #FDF8F3;
  min-height: 60vh;
  gap: 0;
}

.content {
  flex: 1;
  max-width: 550px;
}

.tabs {
  display: flex;
  flex-direction: column;
  margin-left: 8px;
}

.Compte, .Lecteur {
  cursor: pointer;
  padding: 12px 20px;
  border: 2px solid #833c3c;
  background: #FFFFFF;
  color: #333333;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;
  text-align: left;
  border-radius: 12px;
}

.Lecteur {
  margin-top: 0;
}

.Compte:hover, .Lecteur:hover,
.Compte.active, .Lecteur.active {
  background-color: #833c3c;
  color: #FFFFFF;
}
</style>