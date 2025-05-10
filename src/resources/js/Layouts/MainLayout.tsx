// resources/js/Layouts/MainLayout.tsx
import React, { useState } from 'react';
import Sidebar from '@/Components/Sidebar';
import { Bars3Icon } from '@heroicons/react/24/outline';

interface MainLayoutProps {
  title?: string;
  children: React.ReactNode;
}

const MainLayout: React.FC<MainLayoutProps> = ({ title, children }) => {
    const [isSidebarOpen, setSidebarOpen] = useState(true);

    return (
        <div className="flex min-h-screen">
        {/* 開閉ボタン（main外だが、位置を連動） */}
        <button
            className={`fixed top-4 transition-all duration-300 z-50 bg-gray-800 text-white p-2 rounded-md ${
            isSidebarOpen ? 'left-4' : 'left-4'
            }`}
            onClick={() => setSidebarOpen(!isSidebarOpen)}
        >
            <Bars3Icon className="h-6 w-6" />
        </button>

        {/* サイドバー */}
        <Sidebar isOpen={isSidebarOpen} />

        {/* メインコンテンツ */}
        <main
            className={`transition-all duration-300 ${
            isSidebarOpen ? 'ml-64' : 'ml-0 pl-20 pr-10'
            } flex-1 bg-gray-100 p-6`}
        >
            {title && <h1 className="text-2xl font-bold mb-4">{title}</h1>}
            {children}
        </main>
        </div>
    );
};

export default MainLayout;
