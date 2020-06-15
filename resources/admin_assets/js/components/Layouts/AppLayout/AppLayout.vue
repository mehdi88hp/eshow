<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            right
            app
        >
            <v-list dense>
                <v-list-group
                    prepend-icon="mdi-newspaper"
                    value="1"
                >
                    <template v-slot:activator>
                        <v-list-item-title>پست ها</v-list-item-title>
                    </template>
                    <v-list-item link :to="{name:'posts.index'}">
                        <v-list-item-action>
                            <v-icon>mdi-newspaper-variant</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>لیست</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item link :to="{name:'posts.create'}">
                        <v-list-item-action>
                            <v-icon>mdi-new-box</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>پست جدید</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>
                <v-list-group
                    prepend-icon="mdi-order-bool-ascending"
                    value="2"
                >
                    <template v-slot:activator>
                        <v-list-item-title>دسته بندی ها</v-list-item-title>
                    </template>
                    <v-list-item link :to="{name:'categories.index'}">
                        <v-list-item-action>
                            <v-icon>mdi-order-alphabetical-ascending</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>لیست</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item link :to="{name:'categories.create'}">
                        <v-list-item-action>
                            <v-icon>mdi-new-box</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>دسته بندی جدید</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>
                <v-list-item link :to="{name:'media.create'}">
                    <v-list-item-action>
                        <v-icon>mdi-order-alphabetical-ascending</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>گالری</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            color="indigo"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>{{$route.meta.title}}</v-toolbar-title>
            <v-btn small :to="{name: 'posts.create'}">پست جدید</v-btn>
        </v-app-bar>

        <v-content>
            <v-container
                class="fill-height"
                fluid
            >
                <v-row
                    align="center"
                    justify="center"
                >
                    <v-col class="text-center">
                        <router-view></router-view>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
        <v-footer
            color="indigo"
            app
        >
            <span class="white--text">&copy; 2020</span>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        name: "AppLayout",
        props: {
            source: String,
        },
        data: () => ({
            drawer: null,
        }),
    }
</script>
