
import React from 'react';
import { motion } from 'framer-motion';

const Header = () => {
  return (
    <motion.header 
      className="py-6 px-4 md:px-8 flex justify-center items-center"
      initial={{ opacity: 0, y: -20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5 }}
    >
      <div className="text-center">
        <motion.div
          className="mb-6"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.1, duration: 0.7 }}
        >
          <a 
            href="https://www.patrickboghossian.com/" 
            target="_blank" 
            rel="noopener noreferrer"
            className="inline-block hover:opacity-90 transition-opacity"
          >
            <img 
              src="/lovable-uploads/10862b62-a836-4750-9fdf-d1ed7c82776d.png" 
              alt="Patrick Boghossian Fine Jewellery" 
              className="h-auto w-full max-w-[280px] md:max-w-[320px] mx-auto"
            />
          </a>
        </motion.div>
        <motion.h1 
          className="text-3xl md:text-4xl lg:text-5xl font-display font-medium text-burgundy"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.2, duration: 0.7 }}
        >
          Ring Sizer
        </motion.h1>
        <motion.p 
          className="text-sm md:text-base mt-2 text-burgundy/80 font-serif"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.4, duration: 0.7 }}
        >
          Find your perfect fit across international standards
        </motion.p>
      </div>
    </motion.header>
  );
};

export default Header;
