
import React from 'react';
import { motion } from 'framer-motion';

interface RulerGuideProps {
  diameterMm: number;
  visualDiameter: number;
  unit: 'mm' | 'inches';
}

const RulerGuide: React.FC<RulerGuideProps> = ({ diameterMm, visualDiameter, unit }) => {
  // Calculate tick marks for the ruler
  const createTicks = () => {
    const ticks = [];
    const maxDiameter = visualDiameter + 20; // Add some space around
    const tickInterval = unit === 'mm' ? 1 : 0.1; // 1mm or 0.1 inch intervals
    const majorTickInterval = unit === 'mm' ? 5 : 0.5; // Every 5mm or 0.5 inch
    
    const startValue = Math.max(0, Math.floor(diameterMm) - 10); // Start 10mm less than current diameter
    const endValue = Math.ceil(diameterMm) + 10; // End 10mm more than current diameter
    
    for (let i = startValue; i <= endValue; i += tickInterval) {
      const isMajorTick = i % majorTickInterval < 0.01; // Account for floating point precision
      const tickPosition = (i - startValue) / (endValue - startValue) * maxDiameter;
      
      ticks.push(
        <div 
          key={`tick-${i}`} 
          className={`absolute h-${isMajorTick ? '3' : '1.5'} w-px bg-burgundy/70 transform -translate-y-1/2`} 
          style={{ left: tickPosition + 'px', top: '50%' }}
        >
          {isMajorTick && (
            <span className="absolute -top-6 text-xs text-burgundy transform -translate-x-1/2">
              {unit === 'mm' ? i : (i / 25.4).toFixed(1)}
            </span>
          )}
        </div>
      );
    }
    
    return ticks;
  };
  
  return (
    <motion.div 
      className="absolute top-0 left-0 right-0 bottom-0 pointer-events-none"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 0.5 }}
    >
      {/* Horizontal ruler */}
      <div className="absolute top-1/2 left-0 right-0 h-px bg-burgundy/30">
        {createTicks()}
      </div>
      
      {/* Concentric guide circles */}
      <div 
        className="absolute rounded-full border border-dashed border-gold-light/50"
        style={{
          width: visualDiameter + 10 + 'px',
          height: visualDiameter + 10 + 'px',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)'
        }}
      />
      <div 
        className="absolute rounded-full border border-dashed border-gold-light/50"
        style={{
          width: visualDiameter + 5 + 'px',
          height: visualDiameter + 5 + 'px',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)'
        }}
      />
      <div 
        className="absolute rounded-full border border-dashed border-gold-light/50"
        style={{
          width: visualDiameter - 5 + 'px',
          height: visualDiameter - 5 + 'px',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)'
        }}
      />
      <div 
        className="absolute rounded-full border border-dashed border-gold-light/50"
        style={{
          width: visualDiameter - 10 + 'px',
          height: visualDiameter - 10 + 'px',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)'
        }}
      />
    </motion.div>
  );
};

export default RulerGuide;
