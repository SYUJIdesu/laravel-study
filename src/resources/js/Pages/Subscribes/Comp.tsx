import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import { CheckCircleIcon } from '@heroicons/react/24/solid';

const Complete = () => {
    return (
        <div className="flex items-center justify-center min-h-screen bg-gray-100">
            <div className="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-center">
                <CheckCircleIcon className="h-20 w-20 text-green-500 mx-auto mb-4" />
                <h1 className="text-2xl font-bold mb-2">サブスクリプションが完了しました！</h1>
                <p className="text-gray-600 mb-6">
                ご利用ありがとうございます。マイページからプランの確認・変更が可能です。
                </p>
                <a
                href={route('home')}
                className="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"
                >
                ホームに戻る
                </a>
            </div>
        </div>
    );
};

Complete.layout = (page: React.ReactNode) => (
    <MainLayout title="">{page}</MainLayout>
);

export default Complete;
