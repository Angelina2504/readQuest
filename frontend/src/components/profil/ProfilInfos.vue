<template>
    <div class="id-card">
        <div class="photo profil">
          <img :src="avatar || 'https://placehold.co/100x100'" alt="photos de profil">
          <input type="file" v-if="isEditing" @change="handleAvatarChange">
        </div>
        <div class="alias">
            <span><label for="Identifiant">Identifiant</label></span>
            <p v-if="!isEditing">{{alias}}</p>
            <input type="text" v-model="alias" v-else>
            <button class="in-out" @click="aliasPublic = !aliasPublic">{{aliasPublic ? "Public" : "Privé"}}</button>
        </div>
        <div class="email">
            <span><label for="email">Email</label></span>
            <p v-if="!isEditing">{{email}}</p>
            <input type="text" v-model="email" v-else>
             <button class="in-out" @click="emailPublic = !emailPublic">{{emailPublic ? "Public" : "Privé"}}</button>
        </div>
        <div class="birthday">
            <span><label for="birthday">Anniversaire</label></span>
            <p v-if="!isEditing">{{birthday}}</p>
            <input type="date" v-model="birthday" v-else>
             <button class="in-out" @click="birthdayPublic = !birthdayPublic">{{birthdayPublic ? "Public" : "Privé"}}</button>
        </div>
        <div class="gender">
            <span><label for="gender">Genre</label></span>
            <p v-if="!isEditing">{{gender}}</p>
            <input type="text" v-model="gender" v-else>
             <button class="in-out" @click="genderPublic = !genderPublic">{{genderPublic ? "Public" : "Privé"}}</button>
        </div>

        <button class="edit-button" @click="isEditing ? handleSave() : isEditing = true">
        {{ isEditing ? 'Enregistrer' : 'Modifier' }} </button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { profilService } from '@/services/profilService';

const errorMessage = ref(null)
const isLoading = ref(false)

const isEditing = ref(false)
const alias = ref('')
const email = ref('')
const birthday = ref('')
const gender = ref('')
const avatar = ref(null)

const aliasPublic = ref(false)
const emailPublic = ref(false)
const birthdayPublic = ref(false)
const genderPublic = ref(false)

onMounted(async () => {
  try {
    const result = await profilService.getProfil()
    birthday.value = result.birthday
    gender.value = result.gender
    avatar.value = result.avatar ? 'http://localhost:8080/' + result.avatar : null
    console.log(avatar.value)
    alias.value = result.alias
    email.value = result.email

  } catch (error) {
    console.error("Erreur détaillée:", error);
    errorMessage.value = "Data non chargées";
  }
})

const handleSave = async() => {
  isLoading.value = true;
  errorMessage.value = null;
    try {
      await profilService.updateProfile(birthday.value,gender.value)
      isEditing.value = false;
    } catch (error) {
      console.error("Erreur détaillée:", error);
      errorMessage.value = "Modification non enregistrer";
    } finally {
      isLoading.value = false;
    }
    }

const handleAvatarChange = async(event) => {
  isLoading.value = true;
  errorMessage.value = null;
  try {
    const fichier = event.target.files[0]
    const formData = new FormData()
    formData.append('avatar', fichier)
    await profilService.uploadAvatar(formData)
    const result = await profilService.getProfil()
    avatar.value = result.avatar ? 'http://localhost:8080/' + result.avatar : null
  } catch (error) {
    console.error("Erreur détaillée:", error);
    errorMessage.value = "Modification non enregistrer";
  } finally {
      isLoading.value = false;
  }
  }

</script>

<style scoped>
.id-card {
  background: white;
  border: 2px solid #944242;
  border-radius: 16px;
  padding: 40px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.id-card > div {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid #EDE4D3;
}

.id-card > div:last-child {
  border-bottom: none;
}

.id-card > div p,
.id-card > div input {
  text-align: center;
}

.id-card > div .in-out {
  justify-self: end;
}

label {
  font-weight: 600;
  font-size: 14px;
  color: #944242;
}

p {
  margin: 0;
  font-size: 14px;
  color: #333;
}

.photo {
  grid-column: 1 / -1;
  display: flex !important;
  justify-content: center;
  margin-bottom: 8px;
}

.photo img {
  border-radius: 50%;
  width: 100px;
  height: 100px;
  object-fit: cover;
}

.edit-button {
  margin-top: 20px;
  padding: 8px 28px;
  background-color: white;
  border: 2px solid #944242;
  border-radius: 25px;
  color: #944242;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  align-self: center;
}

.edit-button:hover {
  background-color: #944242;
  color: white;
}

.in-out {
  padding: 4px 10px;
  border-radius: 25px;
  border: 1px solid #944242;
  background-color: white;
  color: #944242;
  font-size: 11px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.in-out:hover {
  background-color: #944242;
  color: white;
}
</style>