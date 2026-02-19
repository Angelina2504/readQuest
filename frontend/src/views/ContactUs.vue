<template>
    <div classe="contact-form-container">
        <form @submit.prevent="handleSubmit">
            <div
            v-for="contact in contactForm"
            :key="contact.name"
            class="contact-form">

            <label :for="contact.name">{{ contact.label }}</label>

            <input type="contact.type"
            :placeholder="contact.placeholder">

            </div>
        </form>

    </div>
</template>

<script setup>
    const contactForm =([
        { label:'Email', type:'Email', placeholder:'Email', name:'email', required: true},
        { label:"Objet", type:'text', placeholder:'Objet', name:'objet', required: true},
        { label:"Raconte ton histoire", type:'text', placeholder:'Message', name:'message', required: true}
    ])
</script>

<style scoped>
</style>