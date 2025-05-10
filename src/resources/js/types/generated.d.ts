declare namespace App.Data {
export type PlanData = {
price_id?: string;
unit_amount: number;
currency: string;
interval: string | null;
};
export type PlanWithPlansData = {
plan_id?: string;
name: string;
description: string | null;
plans: Array<App.Data.PlanData>;
};
}
