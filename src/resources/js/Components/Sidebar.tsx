// resources/js/Components/Sidebar.tsx

import { Link } from '@inertiajs/react';
import { HomeIcon, CogIcon, DocumentTextIcon } from '@heroicons/react/24/outline';
import React from 'react';

interface SidebarProps {
    isOpen: boolean;
}

const Sidebar: React.FC<SidebarProps> = ({ isOpen }) => {
    return (
        <aside
        className={`fixed top-0 left-0 h-full bg-gray-800 text-white transition-all duration-300 z-40 ${
            isOpen ? 'w-64 p-10 pt-20' : 'w-0 overflow-hidden'
        }`}
        >
        {isOpen && (
            <>
            <h1 className="text-2xl font-bold mb-6">MyApp</h1>
            <nav className="space-y-4">
                <Link
                    href={route('home')}
                    className="flex items-center p-2 rounded hover:bg-gray-700 transition-colors"
                >
                    <HomeIcon className="h-5 w-5 mr-3" />
                    投稿一覧
                </Link>
                <Link
                    href={route('plans.index')}
                    className="flex items-center p-2 rounded hover:bg-gray-700 transition-colors"
                >
                    <DocumentTextIcon className="h-5 w-5 mr-3" />
                    プラン一覧
                </Link>
                <Link
                    href={route('logout')}
                    className="flex items-center p-2 rounded hover:bg-gray-700 transition-colors"
                >
                    <CogIcon className="h-5 w-5 mr-3" />
                    ログアウト
                </Link>
            </nav>
            </>
        )}
        </aside>
    );
};

export default Sidebar;
