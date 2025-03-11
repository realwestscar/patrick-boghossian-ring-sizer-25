
import React from 'react';
import { motion } from 'framer-motion';
import { RulerIcon, CircleIcon } from 'lucide-react';

interface MeasurementControlsProps {
  unit: 'mm' | 'inches';
  setUnit: (unit: 'mm' | 'inches') => void;
  measurementType: 'diameter' | 'circumference';
  setMeasurementType: (type: 'diameter' | 'circumference') => void;
}

const MeasurementControls: React.FC<MeasurementControlsProps> = ({
  unit,
  setUnit,
  measurementType,
  setMeasurementType,
}) => {
  return (
    <motion.div 
      className="mb-8 flex flex-col md:flex-row items-center justify-center gap-4"
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5, delay: 0.2 }}
    >
      <div className="glassmorphism p-1 rounded-full flex items-center">
        <button
          className={`px-4 py-2 rounded-full transition-all duration-300 ${
            unit === 'mm' ? 'bg-burgundy text-cream' : 'text-burgundy hover:bg-cream/50'
          }`}
          onClick={() => setUnit('mm')}
        >
          Millimeters
        </button>
        <button
          className={`px-4 py-2 rounded-full transition-all duration-300 ${
            unit === 'inches' ? 'bg-burgundy text-cream' : 'text-burgundy hover:bg-cream/50'
          }`}
          onClick={() => setUnit('inches')}
        >
          Inches
        </button>
      </div>

      <div className="glassmorphism p-1 rounded-full flex items-center">
        <button
          className={`px-4 py-2 rounded-full flex items-center gap-2 transition-all duration-300 ${
            measurementType === 'diameter' ? 'bg-burgundy text-cream' : 'text-burgundy hover:bg-cream/50'
          }`}
          onClick={() => setMeasurementType('diameter')}
        >
          <CircleIcon size={16} />
          <span>Diameter</span>
        </button>
        <button
          className={`px-4 py-2 rounded-full flex items-center gap-2 transition-all duration-300 ${
            measurementType === 'circumference' ? 'bg-burgundy text-cream' : 'text-burgundy hover:bg-cream/50'
          }`}
          onClick={() => setMeasurementType('circumference')}
        >
          <RulerIcon size={16} />
          <span>Circumference</span>
        </button>
      </div>
    </motion.div>
  );
};

export default MeasurementControls;
