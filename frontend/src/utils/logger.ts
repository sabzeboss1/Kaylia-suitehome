/**
 * Conditional Logger Utility
 * 
 * Logs only in development mode.
 * In production, errors are sent to error tracking service (Sentry).
 * 
 * Usage:
 *   import { logger } from '@/utils/logger'
 *   logger.log('Debug info')
 *   logger.error('Error occurred', error)
 */

class Logger {
  private isDev = import.meta.env.DEV

  /**
   * Log general information (development only)
   */
  log(...args: any[]): void {
    if (this.isDev) {
      console.log(...args)
    }
  }

  /**
   * Log errors (development: console, production: error tracking)
   */
  error(...args: any[]): void {
    if (this.isDev) {
      console.error(...args)
    } else {
      // In production, send to error tracking service
      this.sendToErrorTracking('error', args)
    }
  }

  /**
   * Log warnings (development only)
   */
  warn(...args: any[]): void {
    if (this.isDev) {
      console.warn(...args)
    }
  }

  /**
   * Log info messages (development only)
   */
  info(...args: any[]): void {
    if (this.isDev) {
      console.info(...args)
    }
  }

  /**
   * Log debug messages (development only)
   */
  debug(...args: any[]): void {
    if (this.isDev) {
      console.debug(...args)
    }
  }

  /**
   * Send errors to tracking service (Sentry, etc.)
   */
  private sendToErrorTracking(level: string, args: any[]): void {
    // Check if Sentry is available
    if (typeof window !== 'undefined' && (window as any).Sentry) {
      const Sentry = (window as any).Sentry
      
      // Convert args to message
      const message = args.map(arg => {
        if (arg instanceof Error) {
          return arg.message
        }
        if (typeof arg === 'object') {
          return JSON.stringify(arg)
        }
        return String(arg)
      }).join(' ')
      
      // Send to Sentry
      if (level === 'error') {
        // If first arg is an Error, capture it as exception
        if (args[0] instanceof Error) {
          Sentry.captureException(args[0])
        } else {
          Sentry.captureMessage(message, 'error')
        }
      }
    } else {
      // Fallback: log to console in production for critical errors
      if (level === 'error') {
        console.error('[Production Error]', ...args)
      }
    }
  }
}

// Export singleton instance
export const logger = new Logger()

// Export for testing
export { Logger }
