<script setup>
import {onMounted, ref} from "vue";

let posts = ref([]);

onMounted(function () {
  fetch('http://localhost:8000/api/posts')
      .then(res => res.json())
      .then(serverPosts => {
        console.log(serverPosts)
        posts.value = serverPosts;
      })
      .catch(ex => {
        console.error(ex)
      })
});


</script>

<template>
  <h1> All Posts </h1>
  <ul>
    <li v-for="(post, index) in posts" :key="index">
      <img :src=post.image_url>
      {{ post.title }}</li>
  </ul>
</template>

<style scoped>

</style>