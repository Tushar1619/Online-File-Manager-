<template>
    <div class="h-screen bg-gray-50 flex w-full gap-4">
        <Navigation></Navigation>
        <main
        @drop.prevent="handleDrop"
        @dragover.prevent="onDragOver"
        @dragleave.prevent="onDragLeave"
        class="flex flex-col flex-1 px-4"
        :class="dragOver ? 'dropzone' : ''"
        >
            <div v-if="dragOver" class="text-gray-500 text-center py-8 text-sm">
                Drop files here to upload
            </div>
            <div v-else>
                <div class="flex items-center justify-between w-full">
                    <SearchForm></SearchForm>
                    <UserSettingsDropdown></UserSettingsDropdown>
                </div>
                <div class="flex-1 flex flex-col">
                    <slot></slot>
                </div>
            </div>
        </main>
        <FormProgress :form="fileUploadForm" />
    </div>
    <Notification />
</template>

<script setup>
import { onMounted, ref } from "vue";
import Navigation from "../Components/app/Navigation.vue";
import SearchForm from "../Components/app/SearchForm.vue";
import UserSettingsDropdown from "../Components/app/UserSettingsDropdown.vue";
import {
    emitter,
    FILE_UPLOAD_STARTED,
    showSuccessNotification,
} from "@/event-bus.js";
import { useForm, usePage } from "@inertiajs/vue3";
import FormProgress from "@/Components/app/FormProgress.vue";
import Notification from "../Components/Notification.vue";
const page = usePage();
const fileUploadForm = useForm({
    files: [],
    relative_paths: [],
    parent_id: null,
});

const dragOver = ref(false);

function onDragOver() {
    dragOver.value = true;
}

function onDragLeave() {
    dragOver.value = false;
}

function handleDrop(ev) {
    dragOver.value = false;
    const files = ev.dataTransfer.files;
    console.log(files);
    if (!files.length) {
        return;
    }

    uploadFiles(files);
}

function uploadFiles(files) {
    fileUploadForm.parent_id = page.props.folder?.data.id;
    fileUploadForm.files = files;
    fileUploadForm.relative_paths = [...files].map((f) => f.webkitRelativePath);
    fileUploadForm.post(route("file.store"), {
        onSuccess: () => {
            showSuccessNotification(`${files.length} files have been uploaded`);
        },
    });
}

onMounted(() => {
    emitter.on(FILE_UPLOAD_STARTED, uploadFiles);
});
</script>

<style scoped>
.dropzone {
    width: 100%;
    height: 100%;
    color: #8d8d8d;
    border: 2px dashed gray;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
