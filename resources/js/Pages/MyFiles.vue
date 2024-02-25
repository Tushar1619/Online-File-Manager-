<template>
  <AuthenticatedLayout>
    <nav class="flex items-center justify-between p-1 mb-3">
      <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li
          v-for="ans of ancestors.data"
          :key="ans.id"
          class="inline-flex items-center"
        >
          <Link
            v-if="!ans.parent_id"
            :href="route('myFiles')"
            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-4 h-4 mr-1"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
              />
            </svg>

            My Files
          </Link>
          <div v-else class="flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-4 h-4"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m8.25 4.5 7.5 7.5-7.5 7.5"
              />
            </svg>
            <Link
              :href="route('myFiles', { folder: ans.path })"
              class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
            >
              {{ ans.name }}
            </Link>
          </div>
        </li>
      </ol>
    </nav>
    <div class="flex-1 overflow-auto">
      <table class="min-w-full">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
              Name
            </th>
            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
              Owner
            </th>
            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
              Last Modified
            </th>
            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
              Size
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="file of allFiles.data"
            :key="file.id"
            @dblclick="openFolder(file)"
            class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 cursor-pointer"
          >
            <td
              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
            >
              <FileIcon :file="file" />
              {{ file.name }}
            </td>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
            >
              {{ file.owner }}
            </td>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
            >
              {{ file.updated_at }}
            </td>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
            >
              {{ file.size }}
            </td>
          </tr>
        </tbody>
      </table>

      <div
        v-if="!allFiles.data.length"
        class="py-8 text-center text-sm text-gray-400"
      >
        There is no data in this folder
      </div>
      <div ref="loadMoreIntersect"></div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, Link } from "@inertiajs/vue3";
import FileIcon from "@/Components/app/FileIcon.vue";
import { onMounted, onUpdated, ref } from "vue";
import { httpGet } from "@/Helper/http-helper.js";
const loadMoreIntersect = ref(null);

const props = defineProps({
  files: Object,
  folder: Object,
  ancestors: Object,
});

const allFiles = ref({
  data: props.files.data,
  next: props.files.links.next,
});

function openFolder(file) {
  if (!file.is_folder) {
    return;
  }
  router.visit(route("myFiles", { folder: file.path }));
}

  function loadMore() {
    if (allFiles.value.next === null) {
      return;
    }

    httpGet(allFiles.value.next).then((res) => {
      allFiles.value.data = [...allFiles.value.data, ...res.data];
      allFiles.value.next = res.links.next;
    });
  }

  onUpdated(() => {
    allFiles.value = {
      data: props.files.data,
      next: props.files.links.next,
    };
  });

  onMounted(() => {
    const observer = new IntersectionObserver(
      (entries) =>
        entries.forEach((entry) => entry.isIntersecting && loadMore()),
      {
        rootMargin: "-250px 0px 0px 0px",
      }
    );

    observer.observe(loadMoreIntersect.value);
  });
</script>