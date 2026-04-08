/// <reference types="vite/client" />
import { WPService, WPMasseuse, WPReservation } from '../types';

const API_URL = import.meta.env.VITE_WP_API_URL || 'https://homemassageapp.ma/wp-json/wp/v2';
const USERNAME = import.meta.env.VITE_WP_USERNAME;
const APP_PASSWORD = import.meta.env.VITE_WP_APP_PASSWORD;

const getAuthHeaders = () => {
  if (!USERNAME || !APP_PASSWORD) return {};
  const token = btoa(`${USERNAME}:${APP_PASSWORD}`);
  return {
    'Authorization': `Basic ${token}`,
  };
};

export const fetchServices = async (): Promise<WPService[]> => {
  try {
    const response = await fetch(`${API_URL}/service_app?_embed&per_page=100`, {
      headers: getAuthHeaders(),
    });
    if (!response.ok) throw new Error('Failed to fetch services');
    const data = await response.json();
    
    // Normalize the sticky property based on the custom field is_sticky or meta
    return data.map((service: any) => {
      const isSticky = 
        service.is_sticky === true || 
        service.is_sticky === 'true' || 
        service.is_sticky === '1' ||
        service.is_sticky === 1 ||
        service.sticky === true ||
        service.sticky === 'true' ||
        service.sticky === '1' ||
        (service.meta && (
          service.meta._mpe2025_is_sticky === true || 
          service.meta._mpe2025_is_sticky === 'true' || 
          service.meta._mpe2025_is_sticky === '1'
        )) ||
        (service.acf && (
          service.acf._mpe2025_is_sticky === true || 
          service.acf._mpe2025_is_sticky === 'true' || 
          service.acf._mpe2025_is_sticky === '1'
        ));

      const imageUrl = service._embedded?.['wp:featuredmedia']?.[0]?.source_url || undefined;

      return {
        ...service,
        sticky: !!isSticky,
        imageUrl
      };
    });
  } catch (error) {
    console.warn('Using mock services due to fetch error:', error);
    return [
      {
        id: 1,
        title: { rendered: 'Massage Relaxant' },
        content: { rendered: '<p>Un massage doux et apaisant pour relâcher les tensions.</p>' },
        excerpt: { rendered: '<p>Détente totale du corps et de l\'esprit.</p>' },
        featured_media: 0,
        sticky: true,
      },
      {
        id: 2,
        title: { rendered: 'Massage Sportif' },
        content: { rendered: '<p>Idéal pour la récupération musculaire après l\'effort.</p>' },
        excerpt: { rendered: '<p>Récupération et soulagement musculaire.</p>' },
        featured_media: 0,
        sticky: true,
      },
      {
        id: 3,
        title: { rendered: 'Massage Thaï' },
        content: { rendered: '<p>Étirements et pressions pour rééquilibrer l\'énergie.</p>' },
        excerpt: { rendered: '<p>Énergie et souplesse retrouvées.</p>' },
        featured_media: 0,
        sticky: false,
      },
      {
        id: 4,
        title: { rendered: 'Massage Californien' },
        content: { rendered: '<p>Longs mouvements fluides pour une relaxation profonde.</p>' },
        excerpt: { rendered: '<p>Relaxation profonde et harmonie.</p>' },
        featured_media: 0,
        sticky: false,
      }
    ];
  }
};

export const fetchMasseuses = async (gender?: 'female' | 'male'): Promise<WPMasseuse[]> => {
  try {
    const url = new URL(`${API_URL}/masseuse`);
    url.searchParams.append('_embed', 'true');
    if (gender) {
      url.searchParams.append('gender_filter', gender);
    }
    
    const response = await fetch(url.toString(), {
      headers: getAuthHeaders(),
    });
    
    if (!response.ok) throw new Error('Failed to fetch masseuses');
    return await response.json();
  } catch (error) {
    console.warn('Using mock masseuses due to fetch error:', error);
    const mocks: WPMasseuse[] = [
      { id: 101, title: { rendered: 'Sarah' }, content: { rendered: '' }, phone: '0600000001', gender: 'female' },
      { id: 102, title: { rendered: 'Nadia' }, content: { rendered: '' }, phone: '0600000002', gender: 'female' },
      { id: 103, title: { rendered: 'Karim' }, content: { rendered: '' }, phone: '0600000003', gender: 'male' },
    ];
    return gender ? mocks.filter(m => m.gender === gender) : mocks;
  }
};

export const createReservation = async (reservation: WPReservation): Promise<WPReservation> => {
  try {
    const response = await fetch(`${API_URL}/reservation`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        ...getAuthHeaders(),
      },
      body: JSON.stringify(reservation),
    });
    
    if (!response.ok) throw new Error('Failed to create reservation');
    return await response.json();
  } catch (error) {
    console.warn('Mocking reservation creation due to fetch error:', error);
    return {
      ...reservation,
      id: Math.floor(Math.random() * 1000) + 1000,
    };
  }
};

export const fetchSettings = async (): Promise<{ whatsapp_number: string }> => {
  try {
    const baseUrl = API_URL.replace('wp/v2', 'mpe/v1');
    const response = await fetch(`${baseUrl}/settings`);
    if (!response.ok) throw new Error('Failed to fetch settings');
    return await response.json();
  } catch (error) {
    console.warn('Failed to fetch settings:', error);
    return { whatsapp_number: '' };
  }
};
