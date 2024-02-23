<template>
  <nav class="min-w-[200px]">
    <div class="h-[80px] px-3 flex-items-center gap-3">
      <Link href="/">
        <ApplicationLogo
          class="block h-9 w-auto fill-current text-gray-800"
        />
      </Link>
      LaraStorage
    </div>

    <div class="px-3">
      <CreateNewDropdown></CreateNewDropdown>
      
      <div class="py-3">
        <NavLink>My Files</NavLink>
        <NavLink>Shared with me</NavLink>
        <NavLink>Shared by me</NavLink>
        <NavLink>Trash</NavLink>
      </div>
    </div>

  </nav>
</template>

<script setup>
  import { Link } from '@inertiajs/vue3';
  import ApplicationLogo from '../../Components/ApplicationLogo.vue';
  import CreateNewDropdown from '../app/CreateNewDropdown.vue';
  import NavLink from '../NavLink.vue';

</script>