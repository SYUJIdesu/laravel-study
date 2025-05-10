// Inertia の型定義
import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { route as ziggyRoute } from 'ziggy-js';

// Ziggy の型定義
declare global {
    interface Window {
        axios: AxiosInstance;
    }

    var route: typeof ziggyRoute;
}

// フォームデータの基本型
export interface FormDataType {
  [key: string]: string | File | null | undefined | Blob | number | boolean;
}

// 共通の PageProps 型
export interface PageProps extends InertiaPageProps {
    auth: {
        user: User | null;
    };
    flash: {
        message: string | null;
        success: string | null;
        error: string | null;
    };
}

// モデルの型定義
export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Post {
    id: number;
    title: string;
    content: string;
    user_id?: number;
    created_at: string;
    updated_at: string;
    user?: User;
}
