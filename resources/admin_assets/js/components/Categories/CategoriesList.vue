<template>
    <v-container fluid>
        <v-data-iterator
            :items="items"
            :items-per-page.sync="itemsPerPage"
            :page="page"
            :search="search"
            :sort-by="sortBy.toLowerCase()"
            :sort-desc="sortDesc"
            hide-default-footer
        >
            <template v-slot:header>
                <v-toolbar
                    dark
                    color="blue darken-3"
                    class="mb-1"
                >
                    <v-text-field
                        v-model="search"
                        clearable
                        flat
                        solo-inverted
                        hide-details
                        prepend-inner-icon="mdi-magnify"
                        label="Search"
                    ></v-text-field>
                    <template v-if="$vuetify.breakpoint.mdAndUp">
                        <v-spacer></v-spacer>
                        <v-select
                            v-model="sortBy"
                            flat
                            solo-inverted
                            hide-details
                            :items="keys"
                            prepend-inner-icon="mdi-magnify"
                            label="Sort by"

                            dir="ltr"
                        ></v-select>
                        <v-spacer></v-spacer>
                        <v-btn-toggle
                            v-model="sortDesc"
                            mandatory
                            dir="ltr"
                        >
                            <v-btn
                                large
                                depressed
                                color="blue"
                                :value="false"
                            >
                                <v-icon>mdi-arrow-up</v-icon>
                            </v-btn>
                            <v-btn
                                large
                                depressed
                                color="blue"
                                :value="true"
                            >
                                <v-icon>mdi-arrow-down</v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </template>
                </v-toolbar>
            </template>

            <template v-slot:default="props">
                <v-row>
                    <v-col
                        v-for="item in props.items"
                        :key="item.name"
                        cols="12"
                        sm="6"
                        md="6"
                        lg="3"
                    >
                        <v-card height="300" :to="{name:'posts.edit',params:{id:item.id}}">
                            <v-card-title class="subheading font-weight-bold">{{ item.title }}</v-card-title>

                            <v-divider></v-divider>
                            <v-list dense>
                                <v-list-item>
                                    <v-list-item-content :class="{ 'blue--text': sortBy === 'excerpt' }">خلاصه
                                    </v-list-item-content>
                                    <v-list-item-content class="align-end"
                                                         :class="{ 'blue--text': sortBy === 'excerpt' }">
                                        {{item.excerpt }}
                                    </v-list-item-content>
                                </v-list-item>
                                <!--                                <v-list-item>-->
                                <!--                                    <v-list-item-content :class="{ 'blue&#45;&#45;text': sortBy === 'title' }">{{index}}-->
                                <!--                                    </v-list-item-content>-->
                                <!--                                    <v-list-item-content class="align-end" :class="{ 'blue&#45;&#45;text': sortBy === index }">-->
                                <!--                                        {{value }}-->
                                <!--                                    </v-list-item-content>-->
                                <!--                                </v-list-item>-->
                            </v-list>
                        </v-card>
                    </v-col>
                </v-row>
            </template>

            <template v-slot:footer>
                <v-row class="mt-2" align="center" justify="center">
                    <span class="grey--text">Items per page</span>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn
                                dark
                                text
                                color="primary"
                                class="ml-2"
                                v-on="on"
                            >
                                {{ itemsPerPage }}
                                <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item
                                v-for="(number, index) in itemsPerPageArray"
                                :key="index"
                                @click="updateItemsPerPage(number)"
                            >
                                <v-list-item-title>{{ number }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>

                    <v-spacer></v-spacer>

                    <span
                        class="mr-4
            grey--text"
                    >
            Page {{ page }} of {{ numberOfPages }}
          </span>
                    <v-btn
                        fab
                        dark
                        color="blue darken-3"
                        class="mr-1"
                        @click="formerPage"
                    >
                        <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn
                        fab
                        dark
                        color="blue darken-3"
                        class="ml-1"
                        @click="nextPage"
                    >
                        <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                </v-row>
            </template>
        </v-data-iterator>
    </v-container>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        name: "CategoriesList",
        data() {
            return {
                itemsPerPageArray: [4, 8, 12],
                search: '',
                filter: {},
                sortDesc: false,
                page: 1,
                itemsPerPage: 4,
                sortBy: 'name',
                keys: [
                    'Name',
                    'Calories',
                    'Fat',
                    'Carbs',
                    'Protein',
                    'Sodium',
                    'Calcium',
                    'Iron',
                ],
                items: [
                    {
                        name: 'Frozen Yogurt',
                        calories: 159,
                        fat: 6.0,
                        carbs: 24,
                        protein: 4.0,
                        sodium: 87,
                        calcium: '14%',
                        iron: '1%',
                    },
                ],
            }
        },
        computed: {
            ...mapState('posts', [
                'test'
            ]),
            numberOfPages() {
                return Math.ceil(this.items.length / this.itemsPerPage)
            },
        },
        methods: {
            nextPage() {
                if (this.page + 1 <= this.numberOfPages) this.page += 1
            },
            formerPage() {
                if (this.page - 1 >= 1) this.page -= 1
            },
            updateItemsPerPage(number) {
                this.itemsPerPage = number
            },
        },
        mounted() {
            axios.post('/admin/contents/posts/all').then(r => {
                this.items = r.data.data
                console.log(r.data)
            })
        }
    }
</script>
