<script setup>
import { onMounted, ref, watch } from 'vue';
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create component
const FilePond = vueFilePond(
    FilePondPluginImagePreview
);

defineProps({
    modelValue: {
        type: Array,
        required: true,
    },
    files: {
        type: Array,
        required: true,
    },
    handleFilePondInit: {
        type: Function,
        required: false,
    },
    name: {
        type: String,
        required: false,
        default: 'file',
    },
    allowMultiple: {
        type: Boolean,
        required: false,
        default: false,
    },
    acceptedFileTypes: {
        type: String,
        required: false,
        default: '*',
    },
});

defineEmits(['update:modelValue']);

const pond = ref(null);

onMounted(() => {

});

const emitFiles = () => {
    let files = pond.value.getFiles();
    let fileIds = [];
    files.forEach(file => {
        //get server file id
        let serverId = JSON.parse(file.serverId);
        let filename = serverId.filename;
        //
        fileIds.push(filename);
    });
    $emit('update:modelValue', fileIds);
};

const handleProcessFile = (error, file) => {
    if (error) {
        console.log('Oh no');
        return;
    }
    emitFiles();
};




defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <file-pond name="file" ref="pond" label-idle="Drop files here..." v-bind:allow-multiple="allowMultiple"
        :accepted-file-types="acceptedFileTypes" server="/api/file-upload" v-bind:files="files"
        v-on:processfile="handleProcessFile">
    </file-pond>
</template>
