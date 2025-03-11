
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
