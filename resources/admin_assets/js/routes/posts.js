const Layout = () => import('../components/Layouts/AppLayout/AppLayout');
const Index = () => import('../components/Posts/PostsList');
const Create = () => import('../components/Posts/PostsCreate');

// import Layout from "../components/Layouts/AppLayout/AppLayout";
// import Index from "../components/Posts/PostsList";

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
                    path: 'admin/contents/posts/index',
                    component: Index,
                    name: 'posts.index',
                    meta: {
                        title: 'لیست پست ها',
                    },
                },
                {
                    path: 'admin/contents/posts/create',
                    component: Create,
                    name: 'posts.create',
                    meta: {
                        title: 'پست جدید',
                    },
                },
            ],
        },
    ];

export default routes;
