<template>
    <v-col cols="12" sm="6" md="6">
        <v-text-field
            label="عنوان"
            reverse
        ></v-text-field>

        <textarea id="mytextarea">Hello, World!</textarea>
    </v-col>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue'
    // Import TinyMCE
    import tinymce from 'tinymce/tinymce';
    // A theme is also required
    import 'tinymce/themes/silver';


    export default {
        name: "PostsCreate",
        components: {
            'editor': Editor
        },
        created() {
            // Initialize the app
            tinymce.init({
                selector: '#mytextarea',
                // plugins: ['paste', 'link']
            });
        }
    }
</script>

