export interface Product {
    product_id: string;
    product_name: string;
    product_type: string;
    product_parent_id?: string | null;
}