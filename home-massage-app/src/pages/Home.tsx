import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { fetchServices } from '../lib/api';
import { WPService } from '../types';
import { Sparkles, Clock, ChevronRight } from 'lucide-react';
import { motion } from 'motion/react';

export default function Home() {
  const [services, setServices] = useState<WPService[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchServices().then(data => {
      setServices(data);
      setLoading(false);
    });
  }, []);

  const stickyServices = services.filter(s => s.sticky);
  const regularServices = services.filter(s => !s.sticky);

  return (
    <div className="min-h-full bg-stone-50 dark:bg-stone-950 pb-20 transition-colors">
      {/* Hero Section */}
      <div className="bg-white dark:bg-stone-900 px-6 pt-10 pb-10 rounded-b-[2rem] shadow-sm border-b border-stone-100 dark:border-stone-800 -mt-6 transition-colors">
        <motion.div 
          initial={{ opacity: 0, y: 10 }}
          animate={{ opacity: 1, y: 0 }}
          className="space-y-3 pt-4"
        >
          <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 text-xs font-medium mb-2 transition-colors">
            <Sparkles className="w-3.5 h-3.5" />
            <span>Bien-être à domicile</span>
          </div>
          <h2 className="text-3xl font-semibold text-stone-800 dark:text-stone-100 tracking-tight leading-tight transition-colors">
            Évadez-vous sans <br />
            <span className="text-teal-600 dark:text-teal-400">quitter la maison.</span>
          </h2>
          <p className="text-stone-500 dark:text-stone-400 text-sm max-w-[280px] leading-relaxed transition-colors">
            Des massages professionnels directement chez vous, quand vous le souhaitez.
          </p>
        </motion.div>
      </div>

      {/* Sticky Services (Glovo Style) */}
      {!loading && stickyServices.length > 0 && (
        <div className="px-6 mt-8 space-y-4">
          <div className="flex items-center justify-between">
            <h3 className="text-lg font-medium text-stone-800 dark:text-stone-100 transition-colors">Les plus demandés</h3>
          </div>
          <div className="flex overflow-x-auto pb-4 gap-4 hide-scrollbar -mx-6 px-6">
            {stickyServices.map((service, index) => (
              <motion.div
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                transition={{ delay: index * 0.1 }}
                key={service.id}
                className="flex-shrink-0"
              >
                <Link
                  to={`/service/${service.id}`}
                  state={{ service }}
                  className="flex flex-col items-center group relative w-[90px] h-[100px]"
                >
                  {/* Outer circle with border */}
                  <div className="w-[80px] h-[80px] bg-white dark:bg-stone-800 rounded-full border-2 border-teal-100 dark:border-teal-900/50 shadow-sm flex items-center justify-center overflow-hidden relative transition-all group-hover:scale-105">
                    <img 
                      src={service.imageUrl || `https://picsum.photos/seed/${service.id}/200/200`} 
                      alt={service.title.rendered}
                      className="w-full h-full object-cover"
                      referrerPolicy="no-referrer"
                    />
                  </div>
                  {/* Label Pill overlapping the circle */}
                  <div className="absolute -bottom-1 bg-white dark:bg-stone-800 px-2 py-1.5 rounded-full shadow-md border border-stone-100 dark:border-stone-700 w-[100px] text-center z-10 transition-colors">
                    <span 
                      className="text-[10px] font-medium text-stone-800 dark:text-stone-200 leading-none block truncate transition-colors"
                      dangerouslySetInnerHTML={{ __html: service.title.rendered }} 
                    />
                  </div>
                </Link>
              </motion.div>
            ))}
          </div>
        </div>
      )}

      {/* Regular Services Section */}
      <div className="px-6 mt-8 space-y-6">
        <div className="flex items-center justify-between">
          <h3 className="text-lg font-medium text-stone-800 dark:text-stone-100 transition-colors">Tous nos massages</h3>
        </div>

        {loading ? (
          <div className="space-y-4">
            {[1, 2, 3].map(i => (
              <div key={i} className="h-32 bg-stone-200/50 dark:bg-stone-800/50 animate-pulse rounded-2xl transition-colors" />
            ))}
          </div>
        ) : (
          <div className="grid gap-4">
            {regularServices.map((service, index) => (
              <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.1 }}
                key={service.id}
              >
                <Link
                  to={`/service/${service.id}`}
                  state={{ service }}
                  className="flex bg-white dark:bg-stone-900 border border-stone-100 dark:border-stone-800 rounded-2xl p-3 shadow-sm hover:shadow-md transition-all group"
                >
                  {/* Image */}
                  <div className="w-24 h-24 rounded-xl overflow-hidden bg-stone-100 dark:bg-stone-800 flex-shrink-0 relative transition-colors">
                    <img 
                      src={service.imageUrl || `https://picsum.photos/seed/${service.id}/200/200?blur=1`} 
                      alt={service.title.rendered}
                      className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                      referrerPolicy="no-referrer"
                    />
                    <div className="absolute inset-0 bg-black/5 dark:bg-black/20 group-hover:bg-transparent transition-colors" />
                  </div>
                  
                  {/* Content */}
                  <div className="ml-4 flex flex-col justify-center flex-1 py-1">
                    <div className="flex justify-between items-start">
                      <h4 
                        className="font-medium text-stone-800 dark:text-stone-100 text-base leading-tight transition-colors pr-2" 
                        dangerouslySetInnerHTML={{ __html: service.title.rendered }} 
                      />
                      {service.price && (
                        <span className="font-semibold text-teal-600 dark:text-teal-400 whitespace-nowrap text-sm">
                          {service.price}
                        </span>
                      )}
                    </div>
                    <div 
                      className="text-xs text-stone-500 dark:text-stone-400 line-clamp-2 mt-1.5 leading-relaxed transition-colors"
                      dangerouslySetInnerHTML={{ __html: service.excerpt.rendered }}
                    />
                    <div className="mt-auto pt-3 flex items-center justify-between">
                      {service.duration ? (
                        <div className="flex items-center gap-1.5 text-xs font-medium text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/30 px-2 py-1 rounded-md transition-colors">
                          <Clock className="w-3.5 h-3.5" />
                          <span>{service.duration}</span>
                        </div>
                      ) : <div />}
                      <div className="w-7 h-7 rounded-full bg-stone-50 dark:bg-stone-800 flex items-center justify-center text-stone-400 dark:text-stone-500 group-hover:bg-teal-600 dark:group-hover:bg-teal-500 group-hover:text-white transition-colors">
                        <ChevronRight className="w-4 h-4" />
                      </div>
                    </div>
                  </div>
                </Link>
              </motion.div>
            ))}
            
            {regularServices.length === 0 && !loading && (
               <div className="text-center py-8 text-stone-500 dark:text-stone-400 text-sm transition-colors">
                 Aucun autre massage disponible pour le moment.
               </div>
            )}
          </div>
        )}
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
      `}} />
    </div>
  );
}
