export interface Deck {
    id: number,
    label: string,
    description: string,
    active: boolean,
    public: boolean,
    user_id: number,
    category_id: number
}