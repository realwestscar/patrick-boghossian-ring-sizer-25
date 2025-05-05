
import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { Slider } from '@/components/ui/slider';

interface RingSizeVisualizerProps {
  unit: 'mm' | 'inches';
  measurementType: 'diameter' | 'circumference';
  onSizeChange: (sizeMm: number) => void;
  calibrationFactor: number;
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

const RingSizeVisualizer: React.FC<RingSizeVisualizerProps> = ({ 
  unit, 
  measurementType, 
  onSizeChange, 
  calibrationFactor 
}) => {
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

  // Calculate visual size scaling based on calibration factor
  let visualDiameter = diameterMm * calibrationFactor;

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

        {/* Physical measurements - horizontal and vertical rulers */}
        {calibrationFactor > 0 && (
          <>
            <div className="absolute left-0 top-1/2 h-px w-full bg-burgundy/10">
              <div className="relative h-4">
                {Array.from({ length: Math.floor(maxDiameter) - Math.floor(minDiameter) + 1 }).map((_, index) => {
                  const mm = Math.floor(minDiameter) + index;
                  const position = ((mm - minDiameter) / (maxDiameter - minDiameter)) * 100;
                  return (
                    <div 
                      key={`h-${mm}`} 
                      className="absolute -translate-x-1/2" 
                      style={{ left: `${position}%`, top: '-8px' }}
                    >
                      <div className="h-3 w-px bg-burgundy/30"></div>
                      {mm % 2 === 0 && (
                        <div className="text-[8px] text-burgundy/50 -translate-y-3">{mm}</div>
                      )}
                    </div>
                  );
                })}
              </div>
            </div>
            <div className="absolute top-0 left-1/2 w-px h-full bg-burgundy/10">
              <div className="relative w-4">
                {Array.from({ length: Math.floor(maxDiameter) - Math.floor(minDiameter) + 1 }).map((_, index) => {
                  const mm = Math.floor(minDiameter) + index;
                  const position = ((mm - minDiameter) / (maxDiameter - minDiameter)) * 100;
                  return (
                    <div 
                      key={`v-${mm}`} 
                      className="absolute -translate-y-1/2" 
                      style={{ top: `${position}%`, left: '-8px' }}
                    >
                      <div className="w-3 h-px bg-burgundy/30"></div>
                      {mm % 2 === 0 && (
                        <div className="text-[8px] text-burgundy/50 -translate-x-3">{mm}</div>
                      )}
                    </div>
                  );
                })}
              </div>
            </div>
          </>
        )}

        {/* Ring visualization */}
        <motion.div 
          className="ring-circle z-10"
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

        {/* Visual guide for placing ring */}
        <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
          <motion.div 
            className="rounded-full border border-gold-light opacity-30"
            style={{
              width: visualDiameter + 20,
              height: visualDiameter + 20
            }}
            initial={{ opacity: 0 }}
            animate={{ opacity: [0.1, 0.3, 0.1] }}
            transition={{ repeat: Infinity, duration: 3 }}
          ></motion.div>
        </div>
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
        <p>For the most accurate measurement, place your ring directly on the circle. Make sure you've calibrated your device first.</p>
      </motion.div>
    </motion.div>
  );
};

export default RingSizeVisualizer;
