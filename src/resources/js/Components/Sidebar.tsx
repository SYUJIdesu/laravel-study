import { Link } from '@inertiajs/react';
import { HomeIcon, DocumentTextIcon, CogIcon } from '@heroicons/react/24/outline';

const Sidebar = () => {
    return (
        <aside className="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white p-6">
            <div className="p-6">
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
                        href={route('logout')}
                        className="flex items-center p-2 rounded hover:bg-gray-700 transition-colors"
                    >
                        <CogIcon className="h-5 w-5 mr-3" />
                        ログアウト
                    </Link>
                </nav>
            </div>
        </aside>
    );
};

export default Sidebar;
