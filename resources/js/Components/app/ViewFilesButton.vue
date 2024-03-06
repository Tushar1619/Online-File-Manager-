<template>
    <PrimaryButton @click="view"> View </PrimaryButton>
    <ViewDialog
        :show="showViewDialog"
        :filepath="filepath"
        @close="close"
        :show-image="showImage"
        :show-pdf="showPdf"
        :show-text="showText"
        :show-video="showVideo"
        :show-audio="showAudio"
    />
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { httpGet } from "@/Helper/http-helper.js";
import { ref } from "vue";
import ViewDialog from "../ViewDialog.vue";

const page = usePage();

const filepath = ref("");
const showViewDialog = ref(false);
const showImage = ref(false);
const showPdf = ref(false);
const showText = ref(false);
const showVideo = ref(false);
const showAudio = ref(false);

const props = defineProps({
    file: Object,
});

const emit = defineEmits(["close"]);

function view() {
    httpGet(route("file.show", { filepath: props.file.storage_path }))
        .then((res) => {
            filepath.value = res.path;
            showViewDialog.value = true;
            if (props.file.mime.includes("image")) {
                showImage.value = true;
            }
            if (props.file.mime.includes("pdf")) {
                showPdf.value = true;
            }
            if (props.file.mime.includes("text")) {
                showText.value = true;
            }
            if (props.file.mime.includes("video")) {
                showVideo.value = true;
            }
            if (props.file.mime.includes("audio")) {
                showAudio.value = true;
            }
        })
        .catch((error) => {
            console.log(error);
        });
}

function close() {
    emit("close");
    showViewDialog.value = false;
}
</script>
