<?php

namespace SprykerFeature\Zed\Calculation\Business\Model\Calculator;

use Generated\Shared\Transfer\CalculationExpenseTotalsTransfer;
use SprykerFeature\Shared\Calculation\Dependency\Transfer\CalculableContainerInterface;
use SprykerFeature\Shared\Calculation\Dependency\Transfer\CalculableItemCollectionInterface;
use SprykerFeature\Shared\Calculation\Dependency\Transfer\TotalsInterface;
use SprykerFeature\Zed\Calculation\Dependency\Plugin\TotalsCalculatorPluginInterface;

class ExpenseTotalsCalculator extends AbstractCalculator implements
    TotalsCalculatorPluginInterface,
    ExpenseTotalsCalculatorInterface
{
    /**
     * @param TotalsInterface $totalsTransfer
     * @param CalculableContainerInterface $calculableContainer
     * @param CalculableItemCollectionInterface $calculableItems
     */
    public function recalculateTotals(
        TotalsInterface $totalsTransfer,
        CalculableContainerInterface $calculableContainer,
        CalculableItemCollectionInterface $calculableItems
    ) {
        $expenseTotal = $this->createExpenseTotalTransfer($calculableContainer, $calculableItems);
        $totalsTransfer->setExpenses($expenseTotal);
    }

    /**
     * @param CalculableContainerInterface $calculableContainer
     * @return int
     */
    public function calculateExpenseTotal(CalculableContainerInterface $calculableContainer)
    {
        $orderExpensesTotal = 0;
        foreach ($calculableContainer->getExpenses() as $expense) {
            $orderExpensesTotal += $expense->getGrossPrice();
        }

        return $orderExpensesTotal;
    }

    /**
     * @param CalculableItemCollectionInterface|CalculableItemInterface[] $calculableItems
     * @return int
     */
    protected function calculateItemExpenseTotal(CalculableItemCollectionInterface $calculableItems)
    {
        $itemExpenseTotal = 0;
        foreach ($calculableItems as $item) {
            foreach ($item->getExpenses() as $expense) {
                $itemExpenseTotal += $expense->getGrossPrice();
            }
        }

        return $itemExpenseTotal;
    }

    /**
     * @param CalculableContainerInterface $calculableContainer
     * @param CalculableItemCollectionInterface|CalculableItemInterface[] $calculableItems
     * @return array
     */
    protected function sumExpenseItems(
        CalculableContainerInterface $calculableContainer,
        CalculableItemCollectionInterface $calculableItems
    ) {
        $orderExpenseItems = [];
        foreach ($calculableContainer->getExpenses() as $expense) {
            $this->transformExpenseToExpenseTotalItemInArray($expense, $orderExpenseItems);
        }

        foreach ($calculableItems as $item) {
            foreach ($item->getExpenses() as $expense) {
                $this->transformExpenseToExpenseTotalItemInArray($expense, $orderExpenseItems);
            }
        }

        return $orderExpenseItems;
    }

    /**
     * @param ExpenseItemInterface $expense
     * @param $arrayOfExpenseTotalItems
     */
    protected function transformExpenseToExpenseTotalItemInArray($expense, &$arrayOfExpenseTotalItems)
    {
        if (!isset($arrayOfExpenseTotalItems[$expense->getType()])) {
            $item = new \Generated\Shared\Transfer\CalculationExpenseTotalItemTransfer();
            $item->setName($expense->getName());
            $item->setType($expense->getType());
        } else {
            $item = $arrayOfExpenseTotalItems[$expense->getType()];
        }

        $item->setGrossPrice($item->getGrossPrice() + $expense->getGrossPrice());
        $item->setPriceToPay($item->getPriceToPay() + $expense->getPriceToPay());
        $arrayOfExpenseTotalItems[$expense->getType()] = $item;
    }

    /**
     * @param CalculableContainerInterface $calculableContainer
     * @param CalculableItemCollectionInterface $calculableItems
     *
     * @return ExpenseTotals
     */
    protected function createExpenseTotalTransfer(
        CalculableContainerInterface $calculableContainer,
        CalculableItemCollectionInterface $calculableItems
    ) {
        $expenseTotalTransfer = new \Generated\Shared\Transfer\CalculationExpenseTotalsTransfer();
        $expenseTotalTransfer->setTotalOrderAmount($this->calculateExpenseTotal($calculableContainer));
        $expenseTotalTransfer->setTotalItemAmount($this->calculateItemExpenseTotal($calculableItems));

        foreach ($this->sumExpenseItems($calculableContainer, $calculableItems) as $expenseTotalItem) {
            $expenseTotalTransfer->addExpenseItem($expenseTotalItem);
        }

        return $expenseTotalTransfer;
    }
}
