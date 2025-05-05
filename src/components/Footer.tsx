
import React from 'react';
import { motion } from 'framer-motion';
import { useOrientation } from '@/hooks/use-orientation';
import { useIsMobile } from '@/hooks/use-mobile';

const Footer = () => {
  const orientation = useOrientation();
  const isMobile = useIsMobile();
  
  return (
    <motion.footer 
      className={`py-6 px-4 border-t border-burgundy/10 text-center text-sm text-burgundy/70 mt-8 ${
        orientation === 'landscape' && isMobile ? 'text-xs' : ''
      }`}
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ delay: 0.8, duration: 0.5 }}
    >
      <div className="max-w-3xl mx-auto">
        <p className="font-serif">
          For precise ring sizing, we recommend visiting a professional jeweler.
        </p>
        
        <div className="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
          <div className="glassmorphism p-3 rounded-lg">
            <h3 className="font-medium mb-1">Best Practice</h3>
            <p>Place your existing ring directly on screen and adjust the circle to match.</p>
          </div>
          
          <div className="glassmorphism p-3 rounded-lg">
            <h3 className="font-medium mb-1">Screen Orientation</h3>
            <p>{isMobile ? "Try both portrait and landscape modes for optimal sizing." : "Adjust your browser window for optimal viewing."}</p>
          </div>
          
          <div className="glassmorphism p-3 rounded-lg">
            <h3 className="font-medium mb-1">Measure at Widest Point</h3>
            <p>For accurate sizing, measure the widest inner part of your ring.</p>
          </div>
        </div>
        
        <p className="mt-4 text-xs font-sans">
          © {new Date().getFullYear()} Ring Sizer Tool
        </p>
      </div>
    </motion.footer>
  );
};

export default Footer;
