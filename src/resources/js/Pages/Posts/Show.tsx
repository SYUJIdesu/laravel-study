import React from 'react';
import { Link, Head } from '@inertiajs/react';
import { PageProps, Post } from '@/types';

interface ShowProps extends PageProps {
    post: Post;
}

export default function Show({ post }: ShowProps) {
    return (
        <>
            <Head title={post.title} />
            <div className="container mx-auto p-4">
                <div className="mb-4">
                    <Link
                        href={route('home')}
                        className="text-blue-600 hover:text-blue-800"
                    >
                        ← 戻る
                    </Link>
                </div>

                <div className="bg-white p-6 rounded-lg shadow-md">
                    <h1 className="text-3xl font-bold mb-2">{post.title}</h1>
                    <p className="text-gray-600 mb-4">
                        {new Date(post.created_at).toLocaleDateString()}
                    </p>
                    <div className="prose max-w-none">
                        <p>{post.content}</p>
                    </div>
                </div>
            </div>
        </>
    );
}
