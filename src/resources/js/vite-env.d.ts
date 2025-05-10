/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_APP_TITLE: string;
  // 他の環境変数をここに追加
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
  readonly glob: (pattern: string) => Record<string, () => Promise<any>>;
  readonly globEager: (pattern: string) => Record<string, any>;
}