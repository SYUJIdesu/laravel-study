import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

interface Post {
    id: number;
    title: string;
    content: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    posts: Post[];
}

const Home = ({ posts = [] }: Props) => {
    return (
        <div className="bg-white rounded-lg shadow-md p-6">

            {posts && posts.length > 0 ? (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {posts.map(post => (
                <div key={post.id} className="bg-gray-50 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow duration-300">
                    <h2 className="text-xl font-semibold text-gray-800 mb-2">
                    <Link
                        // @ts-ignore
                        href={route('posts.show', { post: post.id })}
                        className="text-blue-600 hover:text-blue-800"
                    >
                        {post.title}
                    </Link>
                    </h2>
                    <p className="text-gray-600 text-sm mb-4">
                    {new Date(post.created_at).toLocaleDateString('ja-JP')}
                    </p>
                    <div className="text-gray-700 line-clamp-3 mb-4">
                    {post.content}
                    </div>
                </div>
                ))}
            </div>
            ) : (
            <div className="bg-gray-50 rounded-lg shadow p-8 text-center">
                <p className="text-gray-600 text-lg">投稿がありません。</p>
            </div>
            )}
        </div>
    );
}

// レイアウトを設定
Home.layout = (page: React.ReactNode) => <MainLayout title="投稿一覧">{page}</MainLayout>;

export default Home;
