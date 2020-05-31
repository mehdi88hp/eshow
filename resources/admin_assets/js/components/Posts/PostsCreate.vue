<template>
    <div>
        <v-row justify="center">
            <v-col sm="2">
                <label> عنوان</label>
            </v-col>
            <v-col cols="12" sm="5" md="5">
                <v-text-field
                    label="عنوان"
                    reverse
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col sm="2">
                <label>متن</label>
            </v-col>
            <v-col cols="12" sm="5" md="5" >
                <my-editor></my-editor>
            </v-col>
        </v-row>
    </div>

</template>

<script>


    import MyEditor from "../Layouts/my-editor";

    export default {
        name: "PostsCreate",
        components: {MyEditor},
        mounted() {

        }
    }
</script>

