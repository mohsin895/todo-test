<template>
    <form @submit.prevent="handleSubmit">
      <div>
        <input v-model="title" name="title" type="text" placeholder="Title" />
      </div>
      <div>
        <textarea v-model="body" name="body" placeholder="Body"></textarea>
      </div>
      <button type="submit">Submit</button>
    </form>
  </template>
  
  <script setup>
  import { ref, defineEmits } from 'vue'
  
  const title = ref('')
  const body = ref('')
  
  const emit = defineEmits(['submit'])
  
  function handleSubmit() {
    emit('submit', { title: title.value, body: body.value })
  }
  </script>
  