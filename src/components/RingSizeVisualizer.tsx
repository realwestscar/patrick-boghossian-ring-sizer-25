
import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { Slider } from '@/components/ui/slider';

interface RingSizeVisualizerProps {
  unit: 'mm' | 'inches';
  measurementType: 'diameter' | 'circumference';
  onSizeChange: (sizeMm: number) => void;
}

// Ring size mapping for reference (diameter in millimeters)
const ringSizes = {
  usa: [
    { size: '3', diameterMm: 14.1 },
    { size: '3.5', diameterMm: 14.5 },
    { size: '4', diameterMm: 14.9 },
    { size: '4.5', diameterMm: 15.3 },
    { size: '5', diameterMm: 15.7 },
    { size: '5.5', diameterMm: 16.1 },
    { size: '6', diameterMm: 16.5 },
    { size: '6.5', diameterMm: 16.9 },
    { size: '7', diameterMm: 17.3 },
    { size: '7.5', diameterMm: 17.7 },
    { size: '8', diameterMm: 18.1 },
    { size: '8.5', diameterMm: 18.5 },
    { size: '9', diameterMm: 18.9 },
    { size: '9.5', diameterMm: 19.3 },
    { size: '10', diameterMm: 19.7 },
    { size: '10.5', diameterMm: 20.1 },
    { size: '11', diameterMm: 20.5 },
    { size: '11.5', diameterMm: 20.9 },
    { size: '12', diameterMm: 21.3 },
    { size: '12.5', diameterMm: 21.7 },
    { size: '13', diameterMm: 22.1 },
  ],
};

const RingSizeVisualizer: React.FC<RingSizeVisualizerProps> = ({ unit, measurementType, onSizeChange }) => {
  // Start with a reasonable default diameter
  const minDiameter = 14.0;
  const maxDiameter = 22.5;
  const [diameterMm, setDiameterMm] = useState(17.3); // US size 7 as default
  const [sliderValue, setSliderValue] = useState([(diameterMm - minDiameter) / (maxDiameter - minDiameter) * 100]);

  useEffect(() => {
    onSizeChange(diameterMm);
  }, [diameterMm, onSizeChange]);

  // Calculate circumference from diameter
  const circumference = diameterMm * Math.PI;
  
  // Convert measurement based on unit type
  const displayMeasurement = unit === 'mm' 
    ? measurementType === 'diameter' 
      ? diameterMm.toFixed(2) 
      : circumference.toFixed(2)
    : measurementType === 'diameter'
      ? (diameterMm / 25.4).toFixed(3)
      : (circumference / 25.4).toFixed(3);

  const handleSliderChange = (value: number[]) => {
    setSliderValue(value);
    const newDiameter = minDiameter + (value[0] / 100) * (maxDiameter - minDiameter);
    setDiameterMm(newDiameter);
  };

  // Calculate visual size scaling
  const maxVisualDiameter = 220; // max pixel diameter for the ring visual
  const scale = diameterMm / maxDiameter;
  const visualDiameter = maxVisualDiameter * scale;

  return (
    <motion.div 
      className="w-full max-w-xl mx-auto p-4"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 0.8 }}
    >
      <div className="relative aspect-square mb-8 flex items-center justify-center">
        {/* Background grid pattern */}
        <div className="absolute inset-0 bg-grid opacity-10"></div>

        {/* Ring visualization */}
        <motion.div 
          className="ring-circle"
          style={{ 
            width: `${visualDiameter}px`, 
            height: `${visualDiameter}px`,
          }}
          animate={{ 
            width: `${visualDiameter}px`, 
            height: `${visualDiameter}px` 
          }}
          transition={{ type: "spring", stiffness: 300, damping: 25 }}
        >
          <div className="ring-indicator animate-pulse-ring"></div>
          
          {/* Measurement display */}
          <motion.div 
            className="absolute inset-0 flex items-center justify-center flex-col"
            animate={{ scale: [0.95, 1.05, 1] }}
            transition={{ duration: 0.5 }}
          >
            <span className="font-display text-2xl font-medium text-burgundy">
              {displayMeasurement} {unit}
            </span>
            <span className="text-xs uppercase tracking-wider text-burgundy/70">
              {measurementType}
            </span>
          </motion.div>
        </motion.div>
        
        {/* Dimension arrows */}
        {measurementType === 'diameter' && (
          <>
            <div className="absolute left-0 right-0 h-px bg-burgundy/30 z-10 flex items-center justify-between px-2">
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
            </div>
            <div className="absolute top-0 bottom-0 w-px bg-burgundy/30 z-10 flex flex-col items-center justify-between py-2">
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
              <div className="h-2 w-2 rounded-full bg-burgundy"></div>
            </div>
          </>
        )}
      </div>

      {/* Size slider control */}
      <div className="mb-8 px-6">
        <Slider 
          value={sliderValue} 
          onValueChange={handleSliderChange} 
          max={100} 
          step={0.1}
          className="ring-slider"
        />
      </div>

      {/* Size adjustment tips */}
      <motion.div 
        className="text-center text-sm text-burgundy/80 mt-2 glassmorphism p-4 rounded-lg max-w-sm mx-auto"
        initial={{ opacity: 0, y: 10 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.5 }}
      >
        <p>For the most accurate measurement, use a physical ring that fits well and place it over the circle to match sizes.</p>
      </motion.div>
    </motion.div>
  );
};

export default RingSizeVisualizer;
