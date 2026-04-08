import { useLocation, useNavigate, useParams } from 'react-router-dom';
import { WPService } from '../types';
import { Clock, CheckCircle2 } from 'lucide-react';
import { motion } from 'motion/react';

export default function ServiceDetails() {
  const location = useLocation();
  const navigate = useNavigate();
  const service = location.state?.service as WPService;
  // In a real app we'd fetch if not in state, but we'll assume it's passed for now.

  if (!service) return <div className="p-4 text-stone-800 dark:text-stone-100">Service introuvable</div>;

  return (
    <motion.div 
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      className="flex flex-col min-h-full bg-stone-50 dark:bg-stone-950 transition-colors"
    >
      {/* Hero Image Placeholder */}
      <div className="h-64 bg-stone-200 dark:bg-stone-800 relative overflow-hidden transition-colors">
        <img 
          src={service.imageUrl || `https://picsum.photos/seed/${service.id}/800/600?blur=2`}
          alt={service.title.rendered}
          className="w-full h-full object-cover"
          referrerPolicy="no-referrer"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" />
        <div className="absolute bottom-4 left-4 right-4">
          <h2 className="text-2xl font-semibold text-white" dangerouslySetInnerHTML={{ __html: service.title.rendered }} />
        </div>
      </div>

      <div className="p-6 space-y-6 flex-1">
        <div className="flex items-center gap-4 text-sm text-stone-600 dark:text-stone-300 bg-white dark:bg-stone-900 p-3 rounded-xl shadow-sm border border-stone-100 dark:border-stone-800 transition-colors">
          {service.duration && (
            <>
              <div className="flex items-center gap-1.5">
                <Clock className="w-4 h-4 text-teal-600 dark:text-teal-400" />
                <span className="font-medium">{service.duration}</span>
              </div>
              <div className="w-px h-4 bg-stone-200 dark:bg-stone-700" />
            </>
          )}
          <div className="flex items-center gap-1.5">
            <CheckCircle2 className="w-4 h-4 text-teal-600 dark:text-teal-400" />
            <span className="font-medium">À domicile</span>
          </div>
          {service.price && (
            <>
              <div className="w-px h-4 bg-stone-200 dark:bg-stone-700" />
              <div className="flex items-center gap-1.5">
                <span className="font-semibold text-teal-600 dark:text-teal-400">{service.price}</span>
              </div>
            </>
          )}
        </div>

        <div className="space-y-4">
          <h3 className="text-lg font-medium text-stone-800 dark:text-stone-100 transition-colors">Description</h3>
          <div 
            className="prose prose-stone dark:prose-invert prose-sm max-w-none text-stone-600 dark:text-stone-300 leading-relaxed transition-colors"
            dangerouslySetInnerHTML={{ __html: service.content.rendered }}
          />
        </div>
      </div>

      <div className="p-4 bg-white dark:bg-stone-900 border-t border-stone-100 dark:border-stone-800 sticky bottom-0 transition-colors">
        <button
          onClick={() => navigate(`/book/${service.id}`, { state: { service } })}
          className="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-4 rounded-xl shadow-lg shadow-teal-600/20 active:scale-[0.98] transition-all"
        >
          Réserver ce massage
        </button>
      </div>
    </motion.div>
  );
}
