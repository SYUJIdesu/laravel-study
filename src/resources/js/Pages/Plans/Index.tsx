import { PageProps } from '@/types';
import { usePage, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

type Plan = App.Data.PlanWithPlansData;

const PlansIndex = () => {
    const { plans } = usePage<PageProps & { plans: Plan[] }>().props;

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        {plans.map((product) => (
            <div
                key={product.plan_id}
                className="border rounded shadow p-4 bg-white hover:shadow-lg transition"
            >
            <h2 className="text-xl font-bold mb-2">{product.name}</h2>
            <p className="text-gray-600 mb-4">{product.description}</p>

            <div className="space-y-4">
                {product.plans.map((price) => (
                <div
                    key={price.price_id}
                    className="border p-3 rounded bg-gray-50"
                >
                    <p className="text-lg font-semibold">
                        ¥{price.unit_amount} / {price.interval}
                    </p>
                    <button
                        className="mt-2 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm"
                        onClick={() => {
                            router.post(route('subscribe.checkout'), {
                            price_id: price.price_id,
                            });
                        }}
                    >
                    チェックアウトへ
                    </button>
                </div>
                ))}
            </div>
            </div>
        ))}
        </div>
    );
};

PlansIndex.layout = (page: React.ReactNode) => (
    <MainLayout title="サブスク一覧">{page}</MainLayout>
);

export default PlansIndex;
