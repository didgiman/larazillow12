import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    flash: {
        success?: string;
        error?: string;
        warning?: string;
        info?: string;
        listingToHighlight: number;
    };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    listings: Listing[];
}

export interface Listing {
    id: number;
    beds: number;
    baths: number;
    area: number;
    street: string;
    street_nr: number;
    city: string;
    code: number;
    price: number;
    owner: User;
}

// Generic pagination interface for Laravel's LengthAwarePaginator
export interface LaravelPagination<T> {
    data: T[];
    current_page: number;
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    links: {
        url: string;
        label: string;
        active: boolean;
    }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
}

// Using Omit utility type to exclude 'data' from LaravelPagination
export type PaginationMetaOmit<T = unknown> = Omit<LaravelPagination<T>, 'data'>;

// Specific type for paginated listings
export type PaginatedListings = LaravelPagination<Listing>;

export type BreadcrumbItemType = BreadcrumbItem;

export interface ListingFilters {
    priceFrom: number | null;
    priceTo: number | null;
    areaFrom: number | null;
    areaTo: number | null;
    beds: number | null;
    baths: number | null;
}