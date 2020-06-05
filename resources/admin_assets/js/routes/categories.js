const Layout = () => import('../components/Layouts/AppLayout/AppLayout');
const Index = () => import('../components/Categories/CategoriesList');
const Create = () => import('../components/Categories/CategoriesCreate');
const Edit = () => import('../components/Categories/CategoriesEdit');

// import Layout from "../components/Layouts/AppLayout/AppLayout";
// import Index from "../components/Categories/CategoriesList";

const routes =
    [
        {
            path: '/',
            component: Layout,
            meta: {
                bodyClass: 'layout',
            },
            children: [
                {
                    path: 'admin/contents/categories/index',
                    component: Index,
                    name: 'categories.index',
                    meta: {
                        title: 'لیست پست ها',
                    },
                },
                {
                    path: 'admin/contents/categories/:id/edit',
                    component: Edit,
                    name: 'categories.edit',
                    meta: {
                        title: 'به روز رسانی پست',
                    },
                },
                {
                    path: 'admin/contents/categories/create',
                    component: Create,
                    name: 'categories.create',
                    meta: {
                        title: 'پست جدید',
                    },
                },
            ],
        },
    ];

export default routes;
