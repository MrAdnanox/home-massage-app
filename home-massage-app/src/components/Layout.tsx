import { Outlet, Link, useLocation } from 'react-router-dom';
import { Home, Calendar, User, ArrowLeft } from 'lucide-react';
import { cn } from '../lib/utils';

export default function Layout() {
  const location = useLocation();
  const isHome = location.pathname === '/';

  return (
    <div className="min-h-screen bg-stone-50 dark:bg-stone-950 flex justify-center transition-colors">
      <div className="w-full max-w-md bg-white dark:bg-stone-900 min-h-screen shadow-xl flex flex-col relative transition-colors">
        {/* Header */}
        {isHome ? (
          <header className="bg-[#0a0a0a] px-6 py-5 flex items-center justify-center z-10 relative rounded-b-3xl shadow-md">
            <img 
              src="https://homemassageapp.ma/wp-content/uploads/2026/01/home-massage-APP-logo-1.png" 
              alt="Home Massage App" 
              className="h-14 object-contain"
            />
          </header>
        ) : (
          <header className="sticky top-0 z-10 bg-[#0a0a0a] shadow-md px-4 py-4 flex items-center justify-between">
            <Link to=".." onClick={(e) => {
              e.preventDefault();
              window.history.back();
            }} className="p-2 -ml-2 text-white/80 hover:text-white transition-colors">
              <ArrowLeft className="w-5 h-5" />
            </Link>
            <img 
              src="https://homemassageapp.ma/wp-content/uploads/2026/01/home-massage-APP-logo-1.png" 
              alt="Home Massage App" 
              className="h-8 object-contain"
            />
            <div className="w-9" /> {/* Spacer */}
          </header>
        )}

        {/* Main Content */}
        <main className="flex-1 overflow-y-auto pb-24 bg-stone-50 dark:bg-stone-950 transition-colors">
          <Outlet />
        </main>

        {/* Bottom Navigation */}
        <nav className="absolute bottom-0 w-full bg-white dark:bg-stone-900 border-t border-stone-100 dark:border-stone-800 px-6 py-3 flex justify-center items-center pb-safe transition-colors">
          <Link to="/" className={cn("flex flex-col items-center gap-1 transition-colors", isHome ? "text-teal-600 dark:text-teal-400" : "text-stone-400 dark:text-stone-500")}>
            <Home className="w-6 h-6" />
            <span className="text-[10px] font-medium">Accueil</span>
          </Link>
        </nav>
      </div>
    </div>
  );
}
