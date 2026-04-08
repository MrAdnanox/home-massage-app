import React, { useState, useEffect } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { WPService, WPReservation } from '../types';
import { createReservation, fetchSettings } from '../lib/api';
import { motion, AnimatePresence } from 'motion/react';
import { format, addDays } from 'date-fns';
import { fr } from 'date-fns/locale';
import { User, Calendar as CalendarIcon, MapPin, CheckCircle2, Loader2 } from 'lucide-react';
import { DayPicker } from 'react-day-picker';
import 'react-day-picker/dist/style.css';
import { cn } from '../lib/utils';

type Step = 'gender' | 'datetime' | 'details' | 'success';

export default function BookingFlow() {
  const location = useLocation();
  const navigate = useNavigate();
  const service = location.state?.service as WPService;

  const [step, setStep] = useState<Step>('gender');
  const [gender, setGender] = useState<'female' | 'male' | null>(null);
  
  const [date, setDate] = useState<Date | undefined>(undefined);
  const [time, setTime] = useState<string | null>(null);
  
  const [formData, setFormData] = useState({
    name: '',
    city: '',
    email: '',
    phone: '',
    address: '',
    message: ''
  });

  const [isSubmitting, setIsSubmitting] = useState(false);
  const [whatsappNumber, setWhatsappNumber] = useState<string>('');

  useEffect(() => {
    fetchSettings().then(settings => {
      if (settings && settings.whatsapp_number) {
        setWhatsappNumber(settings.whatsapp_number);
      }
    });
  }, []);

  const availableTimes = ['09:00', '10:30', '14:00', '15:30', '17:00', '18:30'];

  useEffect(() => {
    if (!service) {
      navigate('/');
    }
  }, [service, navigate]);

  const handleGenderSelect = (selectedGender: 'female' | 'male') => {
    setGender(selectedGender);
    setStep('datetime');
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!date || !time || !service || !gender) return;

    setIsSubmitting(true);
    
    const formattedDate = format(date, 'yyyy-MM-dd');
    const genderPref = gender === 'female' ? 'Femme' : 'Homme';

    const reservation: WPReservation = {
      title: `Réservation - ${formData.name} - ${formattedDate}`,
      content: `Préférence thérapeute: ${genderPref}\nVille: ${formData.city}\nAdresse: ${formData.address}\n\n${formData.message}`,
      status: 'publish', // Use 'publish' or 'draft' for WP post status
      meta: {
        _mpe_reservation_date: formattedDate,
        _mpe_reservation_time: time,
        _mpe_reservation_name: formData.name,
        _mpe_reservation_email: formData.email,
        _mpe_reservation_phone: formData.phone,
        _mpe_reservation_city: formData.city,
        _mpe_reservation_object: service.title.rendered,
        _mpe_reservation_message: `Préférence thérapeute: ${genderPref}\nVille: ${formData.city}\nAdresse: ${formData.address}\n\n${formData.message}`,
        _mpe_reservation_page_url: window.location.href,
        _mpe_reservation_status: 'pending'
      }
    };

    try {
      await createReservation(reservation);
      
      const dateStr = format(date, 'EEEE d MMMM yyyy', { locale: fr });
      // Strip HTML tags from title like <br> etc, though rendered is usually plainish text but just in case
      const titlePlain = service.title.rendered.replace(/<[^>]*>?/gm, '');

      let message = `Bonjour,\nJe souhaite réserver un massage.\n\n`;
      message += `*Prestation:* ${titlePlain}\n`;
      message += `*Préférence:* ${genderPref}\n`;
      message += `*Date & Heure:* ${dateStr} à ${time}\n\n`;
      message += `*Nom complet:* ${formData.name}\n`;
      if (formData.city) message += `*Ville:* ${formData.city}\n`;
      message += `*Adresse:* ${formData.address}\n`;
      if (formData.message) message += `\n*Notes:*\n${formData.message}`;

      if (whatsappNumber) {
        const encodedMessage = encodeURIComponent(message);
        // Using window.open to open whatsapp
        window.open(`https://wa.me/${whatsappNumber}?text=${encodedMessage}`, '_blank');
      }

      setStep('success');
    } catch (error) {
      console.error(error);
      alert('Une erreur est survenue lors de la réservation.');
    } finally {
      setIsSubmitting(false);
    }
  };

  if (!service) return null;

  return (
    <div className="flex flex-col min-h-full bg-stone-50 dark:bg-stone-950 transition-colors">
      {/* Progress Bar */}
      {step !== 'success' && (
        <div className="bg-white dark:bg-stone-900 px-6 py-4 border-b border-stone-100 dark:border-stone-800 transition-colors">
          <div className="flex gap-2">
            {['gender', 'datetime', 'details'].map((s, i) => {
              const steps = ['gender', 'datetime', 'details'];
              const currentIndex = steps.indexOf(step);
              const isActive = i <= currentIndex;
              return (
                <div 
                  key={s} 
                  className={cn(
                    "h-1.5 flex-1 rounded-full transition-colors",
                    isActive ? "bg-teal-600 dark:bg-teal-500" : "bg-stone-100 dark:bg-stone-800"
                  )} 
                />
              );
            })}
          </div>
        </div>
      )}

      <div className="flex-1 p-6">
        <AnimatePresence mode="wait">
          {step === 'gender' && (
            <motion.div
              key="gender"
              initial={{ opacity: 0, x: 20 }}
              animate={{ opacity: 1, x: 0 }}
              exit={{ opacity: 0, x: -20 }}
              className="space-y-6"
            >
              <div className="space-y-2">
                <h2 className="text-xl font-semibold text-stone-800 dark:text-stone-100 transition-colors">Préférence de thérapeute</h2>
                <p className="text-sm text-stone-500 dark:text-stone-400 transition-colors">Souhaitez-vous être massé(e) par un homme ou une femme ?</p>
              </div>
              
              <div className="grid gap-4">
                <button
                  onClick={() => handleGenderSelect('female')}
                  className="flex items-center p-4 bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-700 rounded-2xl hover:border-teal-500 dark:hover:border-teal-500 hover:ring-1 hover:ring-teal-500 transition-all text-left"
                >
                  <div className="w-12 h-12 bg-teal-50 dark:bg-teal-900/30 rounded-full flex items-center justify-center text-teal-600 dark:text-teal-400 mr-4 transition-colors">
                    <User className="w-6 h-6" />
                  </div>
                  <div>
                    <h3 className="font-medium text-stone-800 dark:text-stone-100 transition-colors">Une femme</h3>
                    <p className="text-sm text-stone-500 dark:text-stone-400 transition-colors">Masseuse professionnelle</p>
                  </div>
                </button>
                <button
                  onClick={() => handleGenderSelect('male')}
                  className="flex items-center p-4 bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-700 rounded-2xl hover:border-teal-500 dark:hover:border-teal-500 hover:ring-1 hover:ring-teal-500 transition-all text-left"
                >
                  <div className="w-12 h-12 bg-stone-100 dark:bg-stone-800 rounded-full flex items-center justify-center text-stone-600 dark:text-stone-400 mr-4 transition-colors">
                    <User className="w-6 h-6" />
                  </div>
                  <div>
                    <h3 className="font-medium text-stone-800 dark:text-stone-100 transition-colors">Un homme</h3>
                    <p className="text-sm text-stone-500 dark:text-stone-400 transition-colors">Masseur professionnel</p>
                  </div>
                </button>
              </div>
            </motion.div>
          )}

          {step === 'datetime' && (
            <motion.div
              key="datetime"
              initial={{ opacity: 0, x: 20 }}
              animate={{ opacity: 1, x: 0 }}
              exit={{ opacity: 0, x: -20 }}
              className="space-y-8"
            >
              <div className="space-y-2">
                <h2 className="text-xl font-semibold text-stone-800 dark:text-stone-100 transition-colors">Date et heure</h2>
                <p className="text-sm text-stone-500 dark:text-stone-400 transition-colors">Quand souhaitez-vous votre massage ?</p>
              </div>
              
              <div className="space-y-4">
                <h3 className="font-medium text-stone-800 dark:text-stone-100 flex items-center gap-2 transition-colors">
                  <CalendarIcon className="w-4 h-4 text-teal-600 dark:text-teal-400" />
                  Jour de la prestation
                </h3>
                <div className="bg-white dark:bg-stone-900 p-4 rounded-2xl border border-stone-200 dark:border-stone-700 flex justify-center transition-colors">
                  <DayPicker
                    mode="single"
                    selected={date}
                    onSelect={(d) => {
                      setDate(d);
                      setTime(null); // Reset time when date changes
                    }}
                    locale={fr}
                    disabled={{ before: new Date() }}
                    modifiersClassNames={{
                      selected: 'bg-teal-600 text-white hover:bg-teal-700 dark:bg-teal-500 dark:hover:bg-teal-600',
                      today: 'text-teal-600 dark:text-teal-400 font-bold'
                    }}
                    className="!m-0 dark-calendar"
                    styles={{
                      caption: { fontWeight: 600 },
                      head_cell: { fontWeight: 500, fontSize: '0.8rem' },
                      cell: { padding: '0.2rem' },
                      day: { borderRadius: '0.5rem' }
                    }}
                  />
                </div>
              </div>

              {date && (
                <motion.div 
                  initial={{ opacity: 0, y: 10 }}
                  animate={{ opacity: 1, y: 0 }}
                  className="space-y-4"
                >
                  <h3 className="font-medium text-stone-800 dark:text-stone-100 transition-colors">Heures disponibles</h3>
                  <div className="grid grid-cols-3 gap-3">
                    {availableTimes.map((t) => (
                      <button
                        key={t}
                        onClick={() => setTime(t)}
                        className={cn(
                          "py-3 rounded-xl border text-sm font-medium transition-all",
                          time === t
                            ? "bg-teal-50 dark:bg-teal-900/30 border-teal-600 dark:border-teal-500 text-teal-700 dark:text-teal-400"
                            : "bg-white dark:bg-stone-900 border-stone-200 dark:border-stone-700 text-stone-600 dark:text-stone-300 hover:border-teal-200 dark:hover:border-teal-800"
                        )}
                      >
                        {t}
                      </button>
                    ))}
                  </div>
                </motion.div>
              )}

              <div className="pt-4">
                <button
                  disabled={!date || !time}
                  onClick={() => setStep('details')}
                  className="w-full bg-teal-600 hover:bg-teal-700 disabled:bg-stone-200 dark:disabled:bg-stone-800 disabled:text-stone-400 dark:disabled:text-stone-600 text-white font-medium py-4 rounded-xl transition-all"
                >
                  Continuer
                </button>
              </div>
            </motion.div>
          )}

          {step === 'details' && (
            <motion.div
              key="details"
              initial={{ opacity: 0, x: 20 }}
              animate={{ opacity: 1, x: 0 }}
              exit={{ opacity: 0, x: -20 }}
            >
              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="space-y-2">
                  <h2 className="text-xl font-semibold text-stone-800 dark:text-stone-100 transition-colors">Vos coordonnées</h2>
                  <p className="text-sm text-stone-500 dark:text-stone-400 transition-colors">Pour que le thérapeute puisse se rendre chez vous.</p>
                </div>

                <div className="space-y-4">
                  <div>
                    <label className="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1 transition-colors">Nom complet</label>
                    <input
                      required
                      type="text"
                      value={formData.name}
                      onChange={e => setFormData({...formData, name: e.target.value})}
                      className="w-full px-4 py-3 rounded-xl border border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all placeholder-stone-400 dark:placeholder-stone-600"
                      placeholder="Jean Dupont"
                    />
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1 transition-colors">Téléphone</label>
                    <input
                      required
                      type="tel"
                      value={formData.phone}
                      onChange={e => setFormData({...formData, phone: e.target.value})}
                      className="w-full px-4 py-3 rounded-xl border border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all placeholder-stone-400 dark:placeholder-stone-600"
                      placeholder="06 00 00 00 00"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1 transition-colors">Email</label>
                    <input
                      required
                      type="email"
                      value={formData.email}
                      onChange={e => setFormData({...formData, email: e.target.value})}
                      className="w-full px-4 py-3 rounded-xl border border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all placeholder-stone-400 dark:placeholder-stone-600"
                      placeholder="jean@example.com"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1 transition-colors">Ville</label>
                    <select
                      required
                      value={formData.city}
                      onChange={e => setFormData({...formData, city: e.target.value})}
                      className="w-full px-4 py-3 rounded-xl border border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all"
                    >
                      <option value="">Sélectionnez une ville</option>
                      <option value="Casablanca">Casablanca</option>
                      <option value="Rabat">Rabat</option>
                      <option value="Marrakech">Marrakech</option>
                      <option value="Fès">Fès</option>
                      <option value="Tanger">Tanger</option>
                      <option value="Agadir">Agadir</option>
                      <option value="Meknès">Meknès</option>
                      <option value="Oujda">Oujda</option>
                      <option value="Kenitra">Kenitra</option>
                      <option value="Tétouan">Tétouan</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1 transition-colors">Adresse complète</label>
                    <div className="relative">
                      <MapPin className="absolute left-4 top-3.5 w-5 h-5 text-stone-400 dark:text-stone-500" />
                      <input
                        required
                        type="text"
                        value={formData.address}
                        onChange={e => setFormData({...formData, address: e.target.value})}
                        className="w-full pl-11 pr-4 py-3 rounded-xl border border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all placeholder-stone-400 dark:placeholder-stone-600"
                        placeholder="123 rue de la Paix, Ville"
                      />
                    </div>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-1 transition-colors">Notes (optionnel)</label>
                    <textarea
                      value={formData.message}
                      onChange={e => setFormData({...formData, message: e.target.value})}
                      className="w-full px-4 py-3 rounded-xl border border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all resize-none placeholder-stone-400 dark:placeholder-stone-600"
                      rows={3}
                      placeholder="Code d'accès, étage, etc."
                    />
                  </div>
                </div>

                <div className="pt-4">
                  <button
                    type="submit"
                    disabled={isSubmitting}
                    className="w-full flex items-center justify-center bg-teal-600 hover:bg-teal-700 disabled:bg-teal-600/70 text-white font-medium py-4 rounded-xl shadow-lg shadow-teal-600/20 transition-all"
                  >
                    {isSubmitting ? <Loader2 className="w-5 h-5 animate-spin" /> : 'Confirmer la réservation'}
                  </button>
                </div>
              </form>
            </motion.div>
          )}

          {step === 'success' && (
            <motion.div
              key="success"
              initial={{ opacity: 0, scale: 0.95 }}
              animate={{ opacity: 1, scale: 1 }}
              className="flex flex-col items-center justify-center text-center py-12 space-y-6"
            >
              <div className="w-20 h-20 bg-teal-50 dark:bg-teal-900/30 rounded-full flex items-center justify-center text-teal-600 dark:text-teal-400 transition-colors">
                <CheckCircle2 className="w-10 h-10" />
              </div>
              <div className="space-y-2">
                <h2 className="text-2xl font-semibold text-stone-800 dark:text-stone-100 transition-colors">Réservation confirmée !</h2>
                <p className="text-stone-500 dark:text-stone-400 max-w-[280px] mx-auto transition-colors">
                  Votre demande a bien été prise en compte. Notre équipe vous contactera très prochainement.
                </p>
              </div>
              
              <div className="bg-white dark:bg-stone-900 border border-stone-100 dark:border-stone-800 rounded-2xl p-6 w-full text-left space-y-4 mt-4 transition-colors">
                <div>
                  <p className="text-xs text-stone-400 dark:text-stone-500 uppercase font-medium tracking-wider transition-colors">Prestation</p>
                  <p className="font-medium text-stone-800 dark:text-stone-100 transition-colors" dangerouslySetInnerHTML={{ __html: service.title.rendered }} />
                </div>
                <div>
                  <p className="text-xs text-stone-400 dark:text-stone-500 uppercase font-medium tracking-wider transition-colors">Date & Heure</p>
                  <p className="font-medium text-stone-800 dark:text-stone-100 capitalize transition-colors">
                    {date && format(date, 'EEEE d MMMM', { locale: fr })} à {time}
                  </p>
                </div>
                <div>
                  <p className="text-xs text-stone-400 dark:text-stone-500 uppercase font-medium tracking-wider transition-colors">Préférence</p>
                  <p className="font-medium text-stone-800 dark:text-stone-100 transition-colors">
                    {gender === 'female' ? 'Masseuse (Femme)' : 'Masseur (Homme)'}
                  </p>
                </div>
              </div>

              <button
                onClick={() => navigate('/')}
                className="w-full bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-100 font-medium py-4 rounded-xl hover:bg-stone-200 dark:hover:bg-stone-700 transition-colors mt-8"
              >
                Retour à l'accueil
              </button>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
      
      {/* Hide scrollbar utility */}
      <style dangerouslySetInnerHTML={{__html: `
        .hide-scrollbar::-webkit-scrollbar {
          display: none;
        }
        .hide-scrollbar {
          -ms-overflow-style: none;
          scrollbar-width: none;
        }
        .rdp {
          --rdp-cell-size: 40px;
          --rdp-accent-color: #0d9488;
          --rdp-background-color: #f0fdfa;
        }
        .dark .rdp {
          --rdp-accent-color: #14b8a6;
          --rdp-background-color: rgba(13, 148, 136, 0.2);
        }
        .dark-calendar .rdp-caption_label,
        .dark-calendar .rdp-head_cell,
        .dark-calendar .rdp-day {
          color: #f5f5f4;
        }
        .dark-calendar .rdp-day_disabled {
          color: #57534e;
        }
      `}} />
    </div>
  );
}
