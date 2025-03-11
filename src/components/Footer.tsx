
import React from 'react';
import { motion } from 'framer-motion';

const Footer = () => {
  return (
    <motion.footer 
      className="py-6 px-4 border-t border-burgundy/10 text-center text-sm text-burgundy/70"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ delay: 0.8, duration: 0.5 }}
    >
      <p className="font-serif">
        For precise ring sizing, we recommend visiting a professional jeweler.
      </p>
      <p className="mt-2 text-xs font-sans">
        © {new Date().getFullYear()} Ring Sizer Tool
      </p>
    </motion.footer>
  );
};

export default Footer;
