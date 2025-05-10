// resources/js/Layouts/MainLayout.tsx
import React from 'react';
import { Link } from '@inertiajs/react';
import Sidebar from '@/Components/Sidebar';

interface MainLayoutProps {
    title?: string;
    children: React.ReactNode;
}

const MainLayout: React.FC<MainLayoutProps> = ({ title, children }) => {
    return (
        <div className="flex min-h-screen">
            {/* サイドバー */}
            <Sidebar />

            {/* メインコンテンツ */}
            <main className="ml-64 flex-1 bg-gray-100 p-6">
                {title && <h1 className="text-2xl font-bold mb-4">{title}</h1>}
                {children}
            </main>
        </div>
    );
};

export default MainLayout;
