<template>
  <div class="w-[600px] h-[80px] flex items-center">
    <!-- <TextInput
      type="text"
      class="block w-full mr-2"
      v-model="search"
      autocomplete
      @keyup.enter.prevent="onSearch"
      placeholder="Search for files and folders"
      >
      </TextInput> -->
    <input
      v-model="search"
      type="text"
      class="block w-full mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
      @keyup.enter.prevent="onSearch"
      placeholder="Search for files and folders"
    />
  </div>
</template>

<script setup>
import TextInput from "../TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { ON_SEARCH, emitter } from "@/event-bus";

let params = new URLSearchParams();
const search = ref(null);

function onSearch() {
  params.set("search", search.value);
  router.get(window.location.pathname + "?" + params.toString());

  emitter.emit(ON_SEARCH, search.value);
}

onMounted(() => {
  params = new URLSearchParams(window.location.search);
  search.value = params.get("search");
});
</script>
