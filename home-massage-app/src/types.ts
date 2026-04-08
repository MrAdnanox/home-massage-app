export interface WPService {
  id: number;
  title: { rendered: string };
  content: { rendered: string };
  excerpt: { rendered: string };
  featured_media: number;
  sticky?: boolean;
  price?: string;
  duration?: string;
  imageUrl?: string;
  _embedded?: {
    "wp:featuredmedia"?: Array<{
      source_url: string;
    }>;
  };
}

export interface WPMasseuse {
  id: number;
  title: { rendered: string };
  content: { rendered: string };
  phone: string;
  gender: 'female' | 'male';
  _embedded?: {
    "wp:featuredmedia"?: Array<{
      source_url: string;
    }>;
  };
}

export interface WPReservation {
  id?: number;
  title?: string | { rendered: string };
  content?: string | { rendered: string };
  status?: string;
  meta?: {
    _mpe_reservation_date?: string;
    _mpe_reservation_time?: string;
    _mpe_reservation_name?: string;
    _mpe_reservation_email?: string;
    _mpe_reservation_phone?: string;
    _mpe_reservation_city?: string;
    _mpe_reservation_object?: string;
    _mpe_reservation_message?: string;
    _mpe_reservation_page_url?: string;
    _mpe_reservation_status?: string;
  };
  // Keep old fields for backward compatibility during transition
  client_name?: string;
  client_email?: string;
  client_phone?: string;
  trip_date?: string;
  trip_object?: string;
  message?: string;
  page_url?: string;
  masseuse_id?: number;
}
